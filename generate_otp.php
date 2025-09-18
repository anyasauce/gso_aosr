<?php 
require_once __DIR__ . '/config/init.php';

$now = time();

// Prevent resend if requested within 60 seconds
if (isset($_SESSION['last_resend_time']) && ($now - $_SESSION['last_resend_time']) < 60) {
    header("Location: otp.php?error=wait");
    exit;
}

$otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

$_SESSION['otp'] = $otp;
$_SESSION['otp_expires'] = time() + 300;
$_SESSION['last_resend_time'] = $now;

sendOTP($_SESSION['email'], $otp);

$_SESSION['otp_message'] = "A new OTP has been sent to your email.";

header("Location: otp.php?resend=success");
exit;
?>
