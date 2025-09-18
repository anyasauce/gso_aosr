<?php 
require_once '../config/init.php';
require_once '../controllers/PHPMailerController.php';

$email = $_SESSION['email'];
$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT letter_name FROM letters WHERE request_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$pdf = $stmt->get_result()->fetch_assoc();
$pdf_file = file_get_contents('../pdfs/' . $pdf['letter_name']);

if (sendApprovedEmailWithAttachment($email, $pdf_file)) {
    $stmt = $conn->prepare("UPDATE requests SET payment_status = ?, status = ? WHERE id = ?");
    $payment_status = 'paid';
    $status = 'Approved';
    $stmt->bind_param("ssi", $payment_status, $status, $id);
    $stmt->execute();
    header("Location: ../index.php");
} else {
    echo "Failed to send email.";
}



?>