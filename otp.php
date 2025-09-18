<?php 
session_start();

$disabled = false;
$remaining = 0;
if (isset($_SESSION['last_resend_time'])) {
    $elapsed = time() - $_SESSION['last_resend_time'];
    if ($elapsed < 60) {
        $disabled = true;
        $remaining = 60 - $elapsed; // seconds left
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OTP Verification | GSO</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Poppins', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <style>
    body {
      min-height: 100vh;
      overflow-x: hidden;
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-slate-800 to-indigo-900 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
    <!-- Header -->
    <div class="text-center mb-6">
      <svg class="w-12 h-12 mx-auto text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm-6 8v-2a4 4 0 014-4h4a4 4 0 014 4v2H6z" />
      </svg>
      <h1 class="mt-3 text-2xl font-bold text-gray-800">OTP Verification</h1>
      <p class="text-sm text-gray-500 mt-1">
        A 4-digit code was sent to <span class="font-medium text-indigo-600">
          <?= htmlspecialchars($_SESSION['email'] ?? '') ?>
        </span>
      </p>
    </div>

    <?php if (!empty($_SESSION['otp_message'])): ?>
      <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 rounded-lg">
        <?= htmlspecialchars($_SESSION['otp_message']) ?>
      </div>
      <?php unset($_SESSION['otp_message']); ?>
    <?php endif; ?>

    <!-- OTP Form -->
    <form action="verify_otp.php" method="POST" class="space-y-5 mb-4">
      <div class="flex justify-center gap-3">
        <input name="otp[]" maxlength="1" required
          class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
        <input name="otp[]" maxlength="1" required
          class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
        <input name="otp[]" maxlength="1" required
          class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
        <input name="otp[]" maxlength="1" required
          class="otp w-12 h-12 text-center text-xl font-semibold rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
      </div>
      <button type="submit" name="verify_otp"
        class="w-full py-2.5 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition duration-200">
        Verify
      </button>
    </form>

    <!-- Resend Form -->
    <form action="generate_otp.php" method="POST">
      <button type="submit" id="resend-btn"
        class="w-full py-2.5 px-4 border border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition duration-200
        <?php if ($disabled) echo 'opacity-50 cursor-not-allowed'; ?>"
        <?php if ($disabled) echo 'disabled'; ?>>
        Resend Code <span id="countdown"></span>
      </button>
    </form>

  </div>

  <script>
    // Auto move focus
    const inputs = document.querySelectorAll('.otp');
    inputs.forEach((el, idx) => {
      el.addEventListener('input', (e) => {
        if (e.target.value && idx < inputs.length - 1) {
          inputs[idx + 1].focus();
        }
      });
    });


    let remaining = <?= $remaining ?>;
  const btn = document.getElementById('resend-btn');
  const countdown = document.getElementById('countdown');

  if (remaining > 0) {
    countdown.textContent = `(${remaining}s)`;

    let timer = setInterval(() => {
      remaining--;
      countdown.textContent = `(${remaining}s)`;

      if (remaining <= 0) {
        clearInterval(timer);
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
        countdown.textContent = "";
      }
    }, 1000);
  }
  </script>
</body>
</html>
