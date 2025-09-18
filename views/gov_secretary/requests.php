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
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date Range</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Example Row -->
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700">Juan Dela Cruz</td>
                                <td class="px-6 py-4 text-sm text-gray-700">General Assembly</td>
                                <td class="px-6 py-4 text-sm text-gray-700">2025-09-20 → 2025-09-21</td>
                                <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                <button class="px-3 py-1 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600">Approve</button>
                                <button class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg hover:bg-red-600">Reject</button>
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
