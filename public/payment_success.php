<?php
// This page handles successful payments from PayMongo
require_once '../config/init.php';
require_once '../config/paymongo_config.php';
require_once '../controllers/PaymongoController.php';

$message = '';
$status = 'error';

// Get the checkout session ID from URL parameters
$checkoutSessionId = $_GET['checkout_session_id'] ?? null;

if ($checkoutSessionId) {
    try {
        // Verify the payment with PayMongo
        $paymongoController = new PaymongoController();
        $checkoutSession = $paymongoController->retrieveCheckoutSession($checkoutSessionId);
        
        if ($checkoutSession && $checkoutSession->attributes->payment_status === 'paid') {
            // Update the database - find the request with this checkout session ID
            $stmt = $conn->prepare("UPDATE requests SET payment_status = 'Paid', payment_id = ? WHERE paymongo_reference_id = ?");
            $paymentId = $checkoutSession->attributes->payments[0]->id ?? 'N/A';
            $stmt->bind_param("ss", $paymentId, $checkoutSessionId);
            
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $status = 'success';
                $message = 'Payment successful! Your reservation request has been updated.';
            } else {
                $message = 'Payment verified but failed to update request status. Please contact support.';
            }
            $stmt->close();
        } else {
            $message = 'Payment verification failed. Please contact support if you believe this is an error.';
        }
    } catch (Exception $e) {
        error_log("Payment verification error: " . $e->getMessage());
        $message = 'An error occurred while verifying your payment. Please contact support.';
    }
} else {
    $message = 'Invalid payment session. Please contact support.';
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $status === 'success' ? 'Payment Successful' : 'Payment Error' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <?php if ($status === 'success'): ?>
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Payment Successful!</h1>
                <p class="text-gray-600 mb-6"><?= htmlspecialchars($message) ?></p>
                <p class="text-sm text-gray-500 mb-6">You will receive a confirmation email shortly. Your request will be processed by our admin team.</p>
            </div>
        <?php else: ?>
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Payment Error</h1>
                <p class="text-gray-600 mb-6"><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endif; ?>
        
        <div class="flex justify-center">
            <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Return to Home
            </a>
        </div>
    </div>
</body>
</html>