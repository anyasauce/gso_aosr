<?php
$result = include 'controllers/PHPMailerController.php';

if ($result) {
    echo "✅ Email sent successfully!";
} else {
    echo "❌ Email failed!";
}
