<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php' ?>
<body class="bg-gray-50">
  <div class="flex">
    <?php include 'components/sidebar.php' ?> <!-- Same Sidebar -->

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
      <?php include 'components/header.php' ?> <!-- Same Header -->

        <!-- Page Content -->
        <div class="p-4">
            <!-- Request Management Page Content -->
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Manage Requests</h1>
                    <p class="text-gray-500">Review, approve, or reject venue reservation requests.</p>
                </div>

                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 text-center">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Letter Type</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date Sent</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Example Row -->
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">Maria Santos</td>
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">Venue Reservation Letter</td>
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">2025-09-20</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <button class="px-3 py-1 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600">
                                View Details
                            </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
  </div>
</body>
</html>