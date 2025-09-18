<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF; // Use DEBUG_SERVER if you need logs
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'josiahdanielle09gallenero@gmail.com';
    $mail->Password   = 'glvd fvmn kzsj ylqt'; // Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Default sender
    $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'Josiah');
} catch (Exception $e) {
    error_log("Mailer setup error: " . $e->getMessage());
}

// Function uses the global $mail
function sendPendingEmail($email, $name) {
    global $mail; // reuse the same instance

    try {
        $mail->clearAddresses(); // clear old recipients
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Pending Reservation';

        // Load template
        $templatePath = __DIR__ . '/../assets/templates/pending.html';
        if (!file_exists($templatePath)) {
            throw new Exception("Template not found at: " . $templatePath);
        }

        $template = file_get_contents($templatePath);

        // 🔥 Replace placeholders
        $template = str_replace('[Recipient Name]', htmlspecialchars($name), $template);
        $template = str_replace('[Current Year]', date("Y"), $template);

        // Assign the body
        $mail->Body = $template;
        $mail->AltBody = "Dear $name, your reservation is still pending.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: " . $e->getMessage());
        return false;
    }
}

/**
 * Sends an email with a unique PayMongo payment link.
 *
 * @param string $email Recipient's email address.
 * @param string $name Recipient's name.
 * @param int $requestId The ID of the reservation request.
 * @param float $amount The amount to be paid.
 * @param string $paymentLink The unique checkout URL from PayMongo.
 * @return bool True on success, false on failure.
 */
function sendPaymentLinkEmail($email, $name, $requestId, $amount, $paymentLink) {
    global $mail; // Reuse the same configured instance from the top of the file

    try {
        $mail->clearAddresses(); // Clear any previous recipients
        $mail->addAddress($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Required for Your Reservation Request #' . $requestId;
        
        $body = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h2>Your Reservation is Pre-Approved!</h2>
                <p>Dear {$name},</p>
                <p>Your reservation request (ID: <strong>{$requestId}</strong>) has been pre-approved. To finalize your booking, please complete the payment of <strong>₱" . number_format($amount, 2) . "</strong>.</p>
                <p>Please click the button below to proceed with the payment:</p>
                <p style='margin: 20px 0;'>
                    <a href='{$paymentLink}' style='padding: 12px 25px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>
                        Pay Now
                    </a>
                </p>
                <p>If you have any questions, please contact our office.</p>
                <p>Salamat,</p>
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

