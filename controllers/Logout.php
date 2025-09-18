<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../config/init.php';


$stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();

session_destroy();
session_unset();

?>

<script>
    window.alert('Session Expired');
    location.href = '../index.php'
</script>