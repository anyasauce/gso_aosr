<?php 
session_start();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>OTP Verification</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root{
      --m3-primary: #6750A4;
      --m3-on-primary: #FFFFFF;
      --m3-surface: #F7F6FB;
      --m3-outline: #E9E6F7;
    }
  </style>
</head>
<body class="min-h-screen bg-[color:var(--m3-surface)] flex items-center justify-center p-6">
  <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg border border-[color:var(--m3-outline)] p-6">
    <div class="text-center mb-6">
      <h1 class="text-xl font-semibold text-slate-900">Enter OTP</h1>
      <p class="text-sm text-slate-500 mt-1">
        A 4-digit code was sent to <span id="sentTo" class="font-medium"><?=$_SESSION['email']?></span>
      </p>
    </div>

    <!-- OTP Form -->
    <form action="verify_otp.php" method="POST" class="mb-3">
      <div class="flex justify-center gap-3 mb-4">
        <input name="otp[]" maxlength="1" required class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-slate-300 focus:ring-2 focus:ring-[color:var(--m3-primary)]" />
        <input name="otp[]" maxlength="1" required class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-slate-300 focus:ring-2 focus:ring-[color:var(--m3-primary)]" />
        <input name="otp[]" maxlength="1" required class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-slate-300 focus:ring-2 focus:ring-[color:var(--m3-primary)]" />
        <input name="otp[]" maxlength="1" required class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-slate-300 focus:ring-2 focus:ring-[color:var(--m3-primary)]" />
      </div>
      <button type="submit" name = "verify_otp" class="w-full py-2 rounded-lg bg-[color:var(--m3-primary)] text-white font-semibold hover:brightness-95">
        Verify
      </button>
    </form>

    <!-- Resend Form -->
    <form action="generate_otp.php" method="POST">
      <button type="submit" class="w-full py-2 rounded-lg border border-[color:var(--m3-primary)] text-[color:var(--m3-primary)] font-semibold hover:bg-[color:var(--m3-outline)]">
        Resend Code
      </button>
    </form>
  </div>

  <script>
    // Auto move focus
    const inputs = document.querySelectorAll('.otp');
    inputs.forEach((el, idx) => {
      el.addEventListener('input', (e) => {
        if (e.target.value && idx < inputs.length - 1) inputs[idx + 1].focus();
      });
    });
  </script>
</body>
</html>
