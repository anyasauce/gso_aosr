<?php
// 1. INCLUDE CONFIGURATION AND CONTROLLERS
// This assumes your init.php file is in a 'config' folder at the project root.
// Adjust the path if necessary.
require_once __DIR__ . '/../config/init.php';

$message = "Invalid payment session. Please contact support.";
$isSuccess = false;

// 2. GET THE SESSION ID FROM THE URL
$checkoutSessionId = $_GET['session_id'] ?? null;

if ($checkoutSessionId && strpos($checkoutSessionId, 'cs_') === 0) {
    try {
        // 3. VERIFY THE SESSION WITH PAYMONGO
        $paymongo = new PaymongoController();
        $session = $paymongo->retrieveCheckoutSession($checkoutSessionId);

        // 4. CHECK THE PAYMENT STATUS
        // A successful payment will have a payment_intent with a 'succeeded' status.
        if (isset($session->attributes->payment_intent->attributes->status) && $session->attributes->payment_intent->attributes->status === 'succeeded') {
            
            $paymentIntentId = $session->attributes->payment_intent->id;

            // 5. UPDATE YOUR DATABASE
            // Use a prepared statement to prevent SQL injection
            $stmt = $conn->prepare("UPDATE requests SET payment_status = 'Paid', payment_id = ? WHERE paymongo_reference_id = ? AND payment_status = 'Pending Payment'");
            $stmt->bind_param("ss", $paymentIntentId, $checkoutSessionId);
            $stmt->execute();

            // Check if the update was successful
            if ($stmt->affected_rows > 0) {
                $isSuccess = true;
                $message = "Your payment was successful and your reservation has been confirmed!";
                // You could also send a final confirmation email here if you want.
            } else {
                // This can happen if the user refreshes the success page after the DB is already updated.
                // We can check if it's already paid.
                $checkStmt = $conn->prepare("SELECT payment_status FROM requests WHERE paymongo_reference_id = ?");
                $checkStmt->bind_param("s", $checkoutSessionId);
                $checkStmt->execute();
                $result = $checkStmt->get_result()->fetch_assoc();
                if ($result && $result['payment_status'] === 'Paid') {
                     $isSuccess = true;
                     $message = "Your payment was successful and your reservation has been confirmed!";
                } else {
                     $message = "Payment confirmed, but we could not update your reservation record. Please contact support with your Payment ID: " . htmlspecialchars($paymentIntentId);
                }
                $checkStmt->close();
            }
            $stmt->close();
        } else {
            // The payment was not successful (e.g., failed, pending, etc.)
            $message = "Your payment was not completed successfully. Please try again or contact support.";
        }

    } catch (Exception $e) {
        error_log("Payment verification error: " . $e->getMessage());
        $message = "A server error occurred during payment verification. Please contact support.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; background-color: #f4f7f6; }
        .container { text-align: center; padding: 40px; background-color: white; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); max-width: 500px; }
        .icon { font-size: 50px; }
        .success .icon { color: #28a745; }
        .error .icon { color: #dc3545; }
        h1 { margin-top: 20px; color: #333; }
        p { color: #666; font-size: 1.1em; }
        a { display: inline-block; margin-top: 25px; padding: 12px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s; }
        a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container <?php echo $isSuccess ? 'success' : 'error'; ?>">
        <div class="icon">
            <?php echo $isSuccess ? '✔' : '✖'; ?>
        </div>
        <h1><?php echo $isSuccess ? 'Payment Successful!' : 'Payment Error'; ?></h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="/">Return to Home</a>
    </div>
</body>
</html>