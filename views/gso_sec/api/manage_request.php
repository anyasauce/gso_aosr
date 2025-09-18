<?php
header('Content-Type: application/json');

require_once '../../../config/init.php'; 

$response = ['success' => false, 'message' => 'An unknown error occurred.'];
$action = $_REQUEST['action'] ?? null;
$id = $_REQUEST['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    $response['message'] = 'Invalid request ID.';
    echo json_encode($response);
    exit;
}

// Ensure database connection exists
if (!isset($conn) || $conn->connect_error) {
    $response['message'] = 'Database connection failed.';
    error_log('Database connection error in manage_request.php: ' . ($conn->connect_error ?? 'Unknown error'));
    echo json_encode($response);
    exit;
}


switch ($action) {
    case 'get_details':
        // This case seems to be working, no changes needed.
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
        // This case seems to be working, no changes needed.
        $status = $_POST['status'] ?? null;
        $remarks = $_POST['remarks'] ?? '';
        $stmt = $conn->prepare("UPDATE requests SET status = ?, remarks = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $remarks, $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Request has been successfully {$status}.";
        } else {
            $response['message'] = 'Database update failed: ' . $stmt->error;
        }
        $stmt->close();
        break;

    case 'send_payment_link':
        try {
            // 1. Get request details from the database
            $stmt = $conn->prepare("SELECT first_name, last_name, email, payment_amount, event_name, purpose, paymongo_checkout_url FROM requests WHERE id = ? AND status = 'Pre-Approved'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                $response['message'] = 'Request not found or it is not in "Pre-Approved" status.';
                break;
            }
            $requestData = $result->fetch_assoc();
            $stmt->close();
            
            if (!$requestData['payment_amount'] || $requestData['payment_amount'] <= 0) {
                $response['message'] = 'This request has an invalid or zero payment amount.';
                break;
            }
            
            $fullName = $requestData['first_name'] . ' ' . $requestData['last_name'];
            $eventName = $requestData['event_name'] ?: $requestData['purpose'];
            $paymentLink = $requestData['paymongo_checkout_url'];
            
            // 2. Only create a new link if one doesn't already exist
            if (empty($paymentLink)) {
                $paymongoController = new PaymongoController();
                
                $lineItems = [
                    [
                        'currency' => 'PHP',
                        'amount' => intval($requestData['payment_amount'] * 100), // Amount in centavos
                        'description' => "Reservation Payment - " . $eventName,
                        'name' => "Fee for Request #" . $id,
                        'quantity' => 1
                    ]
                ];
                
                // ✅ FIX: Pass the actual user data to the controller method
                $checkoutResponse = $paymongoController->createCheckoutSession($lineItems, $fullName, $requestData['email']);
                
                // ✅ FIX: Detailed error checking for the response from the controller
                if ($checkoutResponse === null) {
                    $response['message'] = 'Failed to communicate with the payment gateway. Check server error logs for details.';
                    break;
                }
                
                if (isset($checkoutResponse->errors)) {
                    $errorDetail = $checkoutResponse->errors[0]->detail ?? 'An unknown error occurred with the payment provider.';
                    $response['message'] = 'Payment Gateway Error: ' . $errorDetail;
                    break;
                }

                $paymentLink = $checkoutResponse->attributes->checkout_url;
                $referenceId = $checkoutResponse->id;
                
                // 3. Update the database with the new link and reference ID
                $updateStmt = $conn->prepare("UPDATE requests SET paymongo_checkout_url = ?, paymongo_reference_id = ?, payment_status = 'Pending Payment' WHERE id = ?");
                $updateStmt->bind_param("ssi", $paymentLink, $referenceId, $id);
                $updateStmt->execute();
                $updateStmt->close();
            }
            
            // 4. Send the email with the payment link
            $emailSent = sendPaymentLinkEmail(
                $requestData['email'], 
                $fullName, 
                $id, 
                $requestData['payment_amount'], 
                'http://localhost/gso_aosr/pay.php?ref_id=' . $referenceId
            );
            
            if ($emailSent) {
                $response['success'] = true;
                $response['message'] = 'Payment link has been successfully sent to ' . $requestData['email'];
            } else {
                $response['message'] = 'Payment link was created, but the email could not be sent. Please check mailer settings.';
            }
            
        } catch (Exception $e) {
            error_log("Send payment link error: " . $e->getMessage());
            $response['message'] = 'A server error occurred. Please check the logs.';
        }
        break;

    default:
        $response['message'] = 'Invalid action specified.';
        break;
}

$conn->close();
echo json_encode($response);