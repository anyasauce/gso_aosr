<?php 
require_once 'config/init.php';

echo $_GET['ref_id'];

$stmt = $conn->prepare("SELECT id, email, paymongo_checkout_url FROM requests WHERE paymongo_reference_id = ?");
$stmt->bind_param('s', $_GET['ref_id']);
$stmt->execute();

$result = $stmt->get_result()->fetch_assoc();


$_SESSION['email'] = $result['email'];
$_SESSION['id'] = $result['id'];

header("Location:" . $result['paymongo_checkout_url'] . "");

?>