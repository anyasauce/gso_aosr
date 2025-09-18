<?php 
require_once 'controllers/PHPMailerController.php';
session_start();

// Generate random 4-digit OTP (zero-padded)
$otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

// Store in session (for later verification)
$_SESSION['otp'] = $otp;
$_SESSION['otp_expires'] = time() + 300; // expires in 5 minutes

sendOTP($_SESSION['email'], $otp);

return $otp;
?>
