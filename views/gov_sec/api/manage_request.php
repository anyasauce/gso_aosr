<?php
header('Content-Type: application/json');

require_once '../../../config/db.php';

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

$action = $_POST['action'] ?? $_GET['action'] ?? null;
$id = $_POST['id'] ?? $_GET['id'] ?? null;

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

    // --- NEW ACTION TO HANDLE PRE-APPROVAL WITH PAYMENT ---
    case 'pre_approve':
        $requires_payment = $_POST['requires_payment'] ?? 'false';
        $amount = $_POST['amount'] ?? 0;
        
        $payment_status = 'Not Required';
        $payment_amount = null;
        $new_status = 'Pre-Approved'; // The approval status

        if ($requires_payment === 'true') {
            if (!is_numeric($amount) || $amount <= 0) {
                $response['message'] = 'A valid payment amount greater than zero is required.';
                echo json_encode($response);
                exit;
            }
            $payment_status = 'Pending Payment';
            $payment_amount = (float)$amount;
        }

        $stmt = $conn->prepare("UPDATE requests SET status = ?, payment_status = ?, payment_amount = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $new_status, $payment_status, $payment_amount, $id);

        if ($stmt->execute()) {
             $response['success'] = true;
             $response['message'] = 'Request has been pre-approved and payment details have been saved.';
        } else {
            $response['message'] = 'Database update failed: ' . $stmt->error;
        }
        $stmt->close();
        break;
        
    case 'update_status':
        // This case now only handles the final Approve/Disapprove actions
        $status = $_POST['status'] ?? null;
        $remarks = $_POST['remarks'] ?? '';

        if (!in_array($status, ['Approved', 'Disapproved'])) {
            $response['message'] = 'Invalid status value provided.';
            break;
        }

        $stmt = $conn->prepare("UPDATE requests SET status = ?, remarks = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $remarks, $id);

        if ($stmt->execute()) {
             $response['success'] = true;
             $response['message'] = "Request status has been updated to {$status}.";
        } else {
             $response['message'] = 'Database update failed: ' . $stmt->error;
        }
        $stmt->close();
        break;

    default:
        $response['message'] = 'Invalid action specified.';
        break;
}

$conn->close();
echo json_encode($response);