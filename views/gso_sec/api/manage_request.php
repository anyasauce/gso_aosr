<?php
header('Content-Type: application/json');

require_once '../../../config/init.php';
require_once '../../../config/paymongo_config.php'; // Contains PAYMONGO_SECRET_KEY and APP_URL
require_once '../../../controllers/PaymongoController.php';
require_once '../../../controllers/PHPMailerController.php'; // Your PHPMailer functions

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Use $_REQUEST to handle both GET and POST for simplicity
$action = $_REQUEST['action'] ?? null;
$id = $_REQUEST['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    $response['message'] = 'Invalid request ID.';
    echo json_encode($response);
    exit;
}

switch ($action) {
    case 'get_details':
        $stmt = $conn->prepare("SELECT * FROM requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $response['success'] = true;
            $response['data'] = $result->fetch_assoc();
        } else {
            $response['message'] = 'Request not found.';
        }
        $stmt->close();
        break;

    case 'update_status':
        $status = $_POST['status'] ?? null;
        $remarks = $_POST['remarks'] ?? '';

        if (!in_array($status, ['Approved', 'Disapproved'])) {
            $response['message'] = 'Invalid status value.';
            break;
        }

        $stmt = $conn->prepare("UPDATE requests SET status = ?, remarks = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $remarks, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = "Request has been successfully {$status}.";
            } else {
                $response['message'] = 'No changes were made.';
            }
        } else {
            $response['message'] = 'Database update failed: ' . $stmt->error;
        }
        $stmt->close();
        break;

    // --- NEW CASE: SEND PAYMENT LINK ---
    case 'send_payment_link':
        try {
            // Get request details first
            $stmt = $conn->prepare("SELECT first_name, last_name, email, payment_amount, event_name, purpose, paymongo_checkout_url FROM requests WHERE id = ? AND status = 'Pre-Approved'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                $response['message'] = 'Request not found or not pre-approved.';
                break;
            }
            
            $requestData = $result->fetch_assoc();
            $stmt->close();
            
            // Check if payment amount exists
            if (!$requestData['payment_amount'] || $requestData['payment_amount'] <= 0) {
                $response['message'] = 'Invalid payment amount for this request.';
                break;
            }
            
            $fullName = $requestData['first_name'] . ' ' . $requestData['last_name'];
            $eventName = $requestData['event_name'] ?: $requestData['purpose'];
            
            // Check if we already have a payment link
            $paymentLink = $requestData['paymongo_checkout_url'];
            
            if (empty($paymentLink)) {
                // Create new PayMongo checkout session
                $paymongoController = new PaymongoController();
                
                $lineItems = [
                    [
                        'currency' => 'PHP',
                        'amount' => intval($requestData['payment_amount'] * 100), // Convert to cents
                        'description' => "GSO AOSR Reservation Payment - " . $eventName,
                        'name' => "Reservation Fee for Request #" . $id,
                        'quantity' => 1
                    ]
                ];
                
                $checkoutSession = $paymongoController->createCheckoutSession($lineItems);
                
                if (!$checkoutSession || !isset($checkoutSession->attributes->checkout_url)) {
                    $response['message'] = 'Failed to create payment link. Please try again.';
                    break;
                }
                
                $paymentLink = $checkoutSession->attributes->checkout_url;
                $referenceId = $checkoutSession->id;
                
                // Update the database with the payment link and reference ID
                $updateStmt = $conn->prepare("UPDATE requests SET paymongo_checkout_url = ?, paymongo_reference_id = ?, payment_status = 'Pending Payment' WHERE id = ?");
                $updateStmt->bind_param("ssi", $paymentLink, $referenceId, $id);
                $updateStmt->execute();
                $updateStmt->close();
            }
            
            // Send email with payment link
            $emailSent = sendPaymentLinkEmail(
                $requestData['email'], 
                $fullName, 
                $id, 
                $requestData['payment_amount'], 
                $paymentLink
            );
            
            if ($emailSent) {
                $response['success'] = true;
                $response['message'] = 'Payment link has been sent successfully to ' . $requestData['email'];
            } else {
                $response['success'] = false;
                $response['message'] = 'Payment link was created but failed to send email. Please try again.';
            }
            
        } catch (Exception $e) {
            error_log("Send payment link error: " . $e->getMessage());
            $response['message'] = 'An error occurred while processing the payment link.';
        }
        break;

    // --- OPTIONAL: MARK AS PAID (for manual verification) ---
    case 'update_payment':
        $payment_status = $_POST['payment_status'] ?? null;

        if ($payment_status !== 'Paid') {
            $response['message'] = 'Invalid payment status provided.';
            break;
        }

        $stmt = $conn->prepare("UPDATE requests SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("si", $payment_status, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = "Payment status updated successfully.";
            } else {
                $response['message'] = 'No changes were made to payment status.';
            }
        } else {
            $response['message'] = 'Database update for payment failed: ' . $stmt->error;
        }
        $stmt->close();
        break;

    default:
        $response['message'] = 'Invalid action specified.';
        break;
}

$conn->close();
echo json_encode($response);
?>