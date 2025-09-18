<?php
require_once '../config/init.php';
require_once '../controllers/PaymongoController.php';

$paymentStatus = 'failed';
$checkoutSessionId = null;
$message = 'An error occurred. No payment session was found.';

if (isset($_SESSION['checkout_session_id'])) {
    $checkoutSessionId = $_SESSION['checkout_session_id'];
    
    unset($_SESSION['checkout_session_id']);

    $paymongoController = new PaymongoController();
    $checkoutSession = $paymongoController->retrieveCheckoutSession($checkoutSessionId);

    if ($checkoutSession && isset($checkoutSession->attributes->payment_intent)) {
        $paymentIntentStatus = $checkoutSession->attributes->payment_intent->attributes->status;

        if ($paymentIntentStatus === 'succeeded') {
            $paymentStatus = 'success';
            $message = 'Salamat gid! Your payment has been successfully confirmed.';
            // --- THIS IS WHERE YOU UPDATE YOUR DATABASE ---
            // Example: updateReservationStatus($your_reservation_id, 'Paid');
        } else {
            $message = "Your payment status is '{$paymentIntentStatus}'. Please contact support.";
        }
    } else {
        $message = 'Could not retrieve payment session details from the server.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-2xl w-full max-w-lg text-center">
        <?php if ($paymentStatus === 'success'): ?>
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Payment Confirmed!</h1>
        <?php else: ?>
            <div class="w-20 h-20 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-6">
                 <svg class="w-12 h-12 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Payment Not Confirmed</h1>
        <?php endif; ?>

        <p class="text-slate-500 mb-8"><?= htmlspecialchars($message) ?></p>
        <div class="bg-slate-50 border rounded-lg px-6 py-4 text-left mb-8">
            <div class="flex justify-between items-center text-sm">
                <p class="text-slate-500">Checkout Session ID:</p>
                <p class="font-mono text-slate-800 font-medium"><?= htmlspecialchars($checkoutSessionId ?? 'N/A') ?></p>
            </div>
        </div>
        <a href="pay.php" class="w-full block bg-indigo-600 text-white py-3 rounded-full font-semibold hover:bg-indigo-700">Return to Payment Page</a>
    </div>
</body>
</html>