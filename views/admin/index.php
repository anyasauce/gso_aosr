<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php' ?>
<body class="bg-gray-50">
  <div class="flex">
    <?php include 'components/sidebar.php' ?>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
      <?php include 'components/header.php' ?>

      <!-- Page Content -->
      <div class="p-4">
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

          <!-- Similar structure for Orders and Revenue cards -->
          <!-- ...existing cards with Tailwind classes... -->

        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-xl shadow-sm mt-6">
          <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h5 class="font-semibold">Recent Orders</h5>
            <button class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
              View All
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                  <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">1</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <img src="https://ui-avatars.com/api/?name=John+Doe" class="w-8 h-8 rounded-full mr-3">
                      <span>John Doe</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-sm text-green-600 bg-green-100 rounded-full">
                      Completed
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">$120</td>
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                      </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                      </svg>
                    </button>
                  </td>
                </tr>
                <!-- Additional rows follow the same pattern -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>