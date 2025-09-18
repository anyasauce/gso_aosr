<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'josiahdanielle09gallenero@gmail.com';
    $mail->Password   = 'glvd fvmn kzsj ylqt';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

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
        $mail->clearAddresses(); 
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


function sendApprovedEmailWithAttachment($email, $attachment = null){
    global $mail;
    try {
        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Approved Reservation';
        
        $template = file_get_contents('../assets/templates/approved.html');
        $mail->Body = $template;

        if ($attachment !== null) {
            $mail->addStringAttachment($attachment, 'letter.pdf', 'base64', 'application/pdf');
        }

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Failed to send email to {$email}. Mailer Error: " . $e->getMessage());
        return false;
    }
}


function sendPendingEmail($email, $fullname){
    global $mail;
    try {
        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Approved Reservation';
        
        $template = file_get_contents('../assets/templates/pending.html');
        $mail->Body = $template;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Failed to send email to {$email}. Mailer Error: " . $e->getMessage());
        return false;
    } 
}

function sendOTP($email, $otp){
    global $mail;
    try {
        $mail->clearAddresses(); 
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';

        $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color:#f9fafb; padding:20px;'>
            <div style='max-width:500px; margin:0 auto; background:#ffffff; padding:20px; border-radius:12px; box-shadow:0 4px 6px rgba(0,0,0,0.1);'>
                <h2 style='color:#4f46e5; text-align:center; margin-bottom:20px;'>🔑 OTP Verification</h2>
                <p style='font-size:16px; color:#374151;'>
                    Hello, <br><br>
                    Use the following One-Time Password (OTP) to continue with your login. This code will expire in <b>5 minutes</b>.
                </p>
                <div style='text-align:center; margin:30px 0;'>
                    <span style='font-size:28px; font-weight:bold; letter-spacing:6px; color:#1f2937; background:#eef2ff; padding:12px 20px; border-radius:8px;'>
                        {$otp}
                    </span>
                </div>
                <p style='font-size:14px; color:#6b7280; text-align:center;'>
                    If you did not request this, please ignore this email.
                </p>
            </div>
        </div>";

        if($mail->send()){
            return true;
        }
        return true;
    } catch (Exception $e) {
        error_log("Failed to send email to {$email}. Mailer Error: " . $e->getMessage());
        return false;
    } 
}

