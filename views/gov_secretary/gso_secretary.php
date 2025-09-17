<!DOCTYPE html>
<html lang="en">
<?php include '../config/init.php'?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
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
<body class="bg-gray-50">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-bold text-indigo-600">GSO Admin</h2>
      </div>
      <nav class="p-6 space-y-4">
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Dashboard</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Requests</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Resources</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Settings</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">

      <!-- Header -->
      <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard Overview</h1>
        <div class="flex items-center space-x-4">
          <span class="text-sm text-gray-600">Welcome, Maverick</span>
          <img src="https://ui-avatars.com/api/?name=Maverick" class="w-8 h-8 rounded-full" alt="Avatar">
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6 space-y-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Pending Requests -->
          <div class="bg-white rounded-xl shadow-sm transition-transform duration-200 hover:-translate-y-1">
            <div class="p-6 flex justify-between items-center">
              <div>
                <h6 class="text-gray-500 mb-2">Pending Requests</h6>
                <h3 class="text-2xl font-bold mb-1">8</h3>
                <span class="text-sm text-orange-500">↑ 2 new today</span>
              </div>
              <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                </svg>
              </div>
            </div>
          </div>

          <!-- Approved Today -->
          <div class="bg-white rounded-xl shadow-sm transition-transform duration-200 hover:-translate-y-1">
            <div class="p-6 flex justify-between items-center">
              <div>
                <h6 class="text-gray-500 mb-2">Approved Today</h6>
                <h3 class="text-2xl font-bold mb-1">12</h3>
                <span class="text-sm text-green-500">↑ 15% from yesterday</span>
              </div>
              <div class="w-12 h-12 bg-green-50 text-green-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                  <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                </svg>
              </div>
            </div>
          </div>

          <!-- Total Processed -->
          <div class="bg-white rounded-xl shadow-sm transition-transform duration-200 hover:-translate-y-1">
            <div class="p-6 flex justify-between items-center">
              <div>
                <h6 class="text-gray-500 mb-2">Total Processed</h6>
                <h3 class="text-2xl font-bold mb-1">156</h3>
                <span class="text-sm text-blue-500">This month</span>
              </div>
              <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- You can continue with the table and other sections here -->

      </main>
    </div>
  </div>

</body>
</html>