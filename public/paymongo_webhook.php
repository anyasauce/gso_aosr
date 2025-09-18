<?php
/**
 * Enhanced PayMongo Webhook Handler
 * This automatically approves requests when payment is confirmed
 */

header('Content-Type: application/json');
require_once '../../config/init.php';
require_once '../../config/paymongo_config.php';
require_once '../../controllers/PHPMailerController.php';

// Log webhook calls for debugging
$log_data = [
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'headers' => getallheaders(),
    'body' => file_get_contents('php://input')
];
error_log('PayMongo Webhook: ' . json_encode($log_data));

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get the raw POST data
    $payload = file_get_contents('php://input');
    $event = json_decode($payload, true);

    // Check if this is a checkout session payment paid event
    if (isset($event['data']['type']) && $event['data']['type'] === 'event') {
        $eventType = $event['data']['attributes']['type'] ?? '';
        
        if ($eventType === 'checkout_session.payment.paid') {
            $checkoutSession = $event['data']['attributes']['data'] ?? null;
            
            if ($checkoutSession && isset($checkoutSession['id'])) {
                $checkoutSessionId = $checkoutSession['id'];
                $paymentStatus = $checkoutSession['attributes']['payment_status'] ?? '';
                
                if ($paymentStatus === 'paid') {
                    // Get payment details
                    $payments = $checkoutSession['attributes']['payments'] ?? [];
                    $paymentId = !empty($payments) ? $payments[0]['id'] : 'webhook_' . time();
                    
                    // Get request ID from metadata or database lookup
                    $requestId = $checkoutSession['attributes']['metadata']['request_id'] ?? null;
                    
                    if (!$requestId) {
                        // Fallback: Look up request ID from database
                        $lookupStmt = $conn->prepare("SELECT id FROM requests WHERE paymongo_reference_id = ?");
                        $lookupStmt->bind_param("s", $checkoutSessionId);
                        $lookupStmt->execute();
                        $lookupResult = $lookupStmt->get_result();
                        
                        if ($lookupResult->num_rows > 0) {
                            $requestId = $lookupResult->fetch_assoc()['id'];
                        }
                        $lookupStmt->close();
                    }
                    
                    if ($requestId) {
                        // Update both payment status AND request status
                        $stmt = $conn->prepare("UPDATE requests SET payment_status = 'Paid', status = 'Approved', payment_id = ? WHERE id = ?");
                        $stmt->bind_param("si", $paymentId, $requestId);
                        
                        if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                error_log("PayMongo Webhook: Successfully updated payment status to 'Paid' and request status to 'Approved' for request ID {$requestId}");
                                
                                // Send confirmation email
                                $requesterStmt = $conn->prepare("SELECT first_name, last_name, email, event_name, purpose FROM requests WHERE id = ?");
                                $requesterStmt->bind_param("i", $requestId);
                                $requesterStmt->execute();
                                $requesterResult = $requesterStmt->get_result();
                                
                                if ($requesterResult->num_rows > 0) {
                                    $requesterData = $requesterResult->fetch_assoc();
                                    $fullName = $requesterData['first_name'] . ' ' . $requesterData['last_name'];
                                    $eventName = $requesterData['event_name'] ?: $requesterData['purpose'];
                                    
                                    // Send approval confirmation email
                                    sendApprovalConfirmationEmailWebhook(
                                        $requesterData['email'],
                                        $fullName,
                                        $requestId,
                                        $eventName,
                                        $paymentId
                                    );
                                }
                                $requesterStmt->close();
                                
                                http_response_code(200);
                                echo json_encode(['message' => 'Payment confirmed and request approved successfully']);
                            } else {
                                error_log("PayMongo Webhook: No records updated for request ID {$requestId}");
                                http_response_code(404);
                                echo json_encode(['error' => 'Request not found']);
                            }
                        } else {
                            error_log("PayMongo Webhook: Database error - " . $stmt->error);
                            http_response_code(500);
                            echo json_encode(['error' => 'Database error']);
                        }
                        $stmt->close();
                    } else {
                        error_log("PayMongo Webhook: Could not determine request ID for checkout session {$checkoutSessionId}");
                        http_response_code(400);
                        echo json_encode(['error' => 'Could not determine request ID']);
                    }
                } else {
                    error_log("PayMongo Webhook: Payment status is not 'paid': {$paymentStatus}");
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid payment status']);
                }
            } else {
                error_log("PayMongo Webhook: Invalid checkout session data");
                http_response_code(400);
                echo json_encode(['error' => 'Invalid checkout session data']);
            }
        } else {
            // Different event type, acknowledge but don't process
            http_response_code(200);
            echo json_encode(['message' => 'Event acknowledged but not processed']);
        }
    } else {
        error_log("PayMongo Webhook: Invalid event structure");
        http_response_code(400);
        echo json_encode(['error' => 'Invalid event structure']);
    }
    
} catch (Exception $e) {
    error_log("PayMongo Webhook Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
} finally {
    $conn->close();
}

/**
 * Send approval confirmation email via webhook
 */
function sendApprovalConfirmationEmailWebhook($email, $name, $requestId, $eventName, $paymentId) {
    global $mail;
    
    try {
        $mail->clearAddresses();
        $mail->addAddress($email, $name);
        
        $mail->isHTML(true);
        $mail->Subject = 'Reservation Automatically Approved - Request #' . $requestId;
        
        $body = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h2 style='color: #16a34a;'>Payment Confirmed - Reservation Approved!</h2>
                <p>Dear {$name},</p>
                <p>Your payment has been successfully processed and your reservation request (ID: <strong>{$requestId}</strong>) has been <strong style='color: #16a34a;'>automatically approved</strong>.</p>
                <p><strong>Event/Purpose:</strong> {$eventName}</p>
                <p><strong>Payment Reference:</strong> {$paymentId}</p>
                <p>Your reservation is now confirmed. No further action is required from your side.</p>
                <p>Thank you for using our reservation system!</p>
                <p>Salamat,</p>
                <p><strong>The GSO AOSR Team</strong></p>
            </div>
        ";
        
        $mail->Body = $body;
        $mail->AltBody = "Dear {$name},\nYour payment has been confirmed and your reservation request (ID: {$requestId}) has been automatically approved.\nEvent: {$eventName}\nPayment Reference: {$paymentId}";
        
        $mail->send();
        error_log("Webhook: Approval confirmation email sent to {$email} for request {$requestId}");
        return true;
    } catch (Exception $e) {
        error_log("Webhook: Failed to send approval confirmation email to {$email}. Error: " . $e->getMessage());
        return false;
    }
}
?>