<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | GSO</title>
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
        <!-- Logo / Title -->
        <div class="text-center mb-6">
            <svg class="w-12 h-12 mx-auto text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm-6 8v-2a4 4 0 014-4h4a4 4 0 014 4v2H6z" />
            </svg>
            <h1 class="mt-3 text-2xl font-bold text-gray-800">GSO Login</h1>
            <p class="text-sm text-gray-500">Sign in with your email and password</p>
        </div>

        <!-- Login Form -->
        <form action="../../controllers/AuthController.php" method="post" class="space-y-5">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 placeholder-gray-400"
                    placeholder="Enter your email" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 placeholder-gray-400"
                    placeholder="Enter your password" required>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" name="login"
                    class="w-full py-2.5 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition duration-200">
                    Login
                </button>
            </div>
        </form>

        <!-- Extra Links -->
        <div class="text-center mt-5">
            <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
        </div>
    </div>

</body>

</html>