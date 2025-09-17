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

