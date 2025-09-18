<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// ✅ FIX: REMOVED the 'require_once' for autoload.php. 
// The central 'config/init.php' file now handles this.

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF; // Use DEBUG_SERVER for detailed logs
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'josiahdanielle09gallenero@gmail.com'; // Your Gmail address
    $mail->Password   = 'glvd fvmn kzsj ylqt'; // Your Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Default sender
    $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'GSO AOSR Admin');

} catch (Exception $e) {
    error_log("PHPMailer setup error: " . $e->getMessage());
}


/**
 * Sends an email with a unique PayMongo payment link.
 */
function sendPaymentLinkEmail($email, $name, $requestId, $amount, $paymentLink) {
    global $mail; 

    try {
        $mail->clearAddresses(); // Clear any previous recipients
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Payment Required for Your Reservation Request #' . $requestId;
        
        $body = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h2>Your Reservation is Pre-Approved!</h2>
                <p>Dear {$name},</p>
                <p>Your reservation request (ID: <strong>{$requestId}</strong>) has been pre-approved. To finalize your booking, please complete the payment of <strong>₱" . number_format($amount, 2) . "</strong>.</p>
                <p style='margin: 20px 0;'>
                    <a href='{$paymentLink}' style='padding: 12px 25px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>
                        Pay Now via PayMongo
                    </a>
                </p>
                <p>If you have any questions, please contact our office.</p>
                <p>Thank you,</p>
                <p><strong>The GSO AOSR Team</strong></p>
            </div>
        ";

        $mail->Body = $body;
        $mail->AltBody = "Dear {$name},\nYour reservation request (ID: {$requestId}) requires a payment of PHP " . number_format($amount, 2) . ".\nPlease visit this link to pay: {$paymentLink}";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Failed to send payment link email to {$email}. Mailer Error: " . $e->getMessage());
        return false;
    }
}