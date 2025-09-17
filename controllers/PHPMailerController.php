<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    $mail->isSMTP();                                    
    $mail->Host       = 'smtp.gmail.com';                  
    $mail->SMTPAuth   = true;                              
    $mail->Username   = 'josiahdanielle09gallenero@gmail.com';             
    $mail->Password   = 'glvd fvmn kzsj ylqt';           
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    
    $mail->Port       = 465;                              

    $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'Josiah');
    $mail->addAddress('josiahdanielle09gallenero@gmail.com', 'Recipient Name'); 

    $mail->isHTML(true); 
    $mail->Subject = 'Here is the subject from PHPMailer';
    $mail->Body    = '<h1>This is the HTML message body</h1><p>Sent from your PHP script in <b>Iloilo City!</b></p>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    return true;
} catch (Exception $e) {
    return false;
}