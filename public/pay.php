<?php
require_once '../config/init.php';
require_once '../controllers/PaymongoController.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['amount']) && is_numeric($_POST['amount'])) {
        $amount = (float)$_POST['amount'];
        $amountInCents = $amount * 100;
        $lineItems = [
            [
                'currency' => 'PHP',
                'amount' => $amountInCents,
                'name' => 'Reservation Fee',
                'quantity' => 1
            ]
        ];

        $paymongoController = new PaymongoController();
        $checkoutSession = $paymongoController->createCheckoutSession($lineItems);

        if ($checkoutSession && isset($checkoutSession->attributes->checkout_url)) {
            $_SESSION['checkout_session_id'] = $checkoutSession->id;
            
            header('Location: ' . $checkoutSession->attributes->checkout_url);
            exit();
        } else {
            $error = "Could not create checkout session. Please check API keys.";
        }
    } else {
        $error = "Please enter a valid amount.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayMongo - Checkout Session</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
        <h1 class="text-2xl font-bold text-slate-800 mb-6 text-center">Checkout Session Flow</h1>
        <?php if ($error): ?>
            <div class="bg-rose-100 text-rose-700 p-3 rounded-lg mb-4 text-sm"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="pay.php">
            <div>
                <label for="amount" class="block text-sm font-medium text-slate-600 mb-1">Amount (PHP)</label>
                <input type="number" name="amount" id="amount" step="0.01" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5" placeholder="e.g., 100.00" required>
            </div>
            <button type="submit" class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-full font-semibold hover:bg-indigo-700">Pay with GCash</button>
        </form>
    </div>
</body>
</html>