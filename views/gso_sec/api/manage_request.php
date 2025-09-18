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

    case 'update_status':
        $stmt = $conn->prepare("SELECT * FROM requests WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();


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
                $response['message'] = 'No changes were made. The request might already have this status.';
            }
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