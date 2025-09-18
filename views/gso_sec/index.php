<?php
// This session start should be at the very top of your file
session_start();

// Redirect if user is not logged in (example of a guard clause)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit();
}

// Include your database connection
require_once '../../config/db.php';

// Fetching dashboard data (example queries)
$total_requests = $conn->query("SELECT COUNT(*) as count FROM requests")->fetch_assoc()['count'];
$pending_requests = $conn->query("SELECT COUNT(*) as count FROM requests WHERE status = 'Pre-Approved'")->fetch_assoc()['count'];
$approved_requests = $conn->query("SELECT COUNT(*) as count FROM requests WHERE status = 'Approved'")->fetch_assoc()['count'];
$disapproved_requests = $conn->query("SELECT COUNT(*) as count FROM requests WHERE status = 'Disapproved'")->fetch_assoc()['count'];

// Fetch recent requests for the table
$recent_requests_query = $conn->query("SELECT id, first_name, last_name, purpose, start_date, status FROM requests ORDER BY id DESC LIMIT 5");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSO Secretary Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden"></div>

    <div class="relative min-h-screen lg:flex">
        
        <?php include 'components/sidebar.php'; // Your responsive sidebar ?>

        <div class="flex-1">
            
            <?php include 'components/header.php'; // Your responsive header ?>

            <main class="p-4 sm:p-6 lg:p-10">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900">Dashboard Overview</h1>
                    <p class="text-slate-500 mt-1">Welcome back, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>! Here's a summary of recent activity.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Total Requests</p>
                            <p class="text-3xl font-bold text-slate-800"><?= $total_requests ?></p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Pending Review</p>
                            <p class="text-3xl font-bold text-slate-800"><?= $pending_requests ?></p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Approved</p>
                            <p class="text-3xl font-bold text-slate-800"><?= $approved_requests ?></p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-rose-100 text-rose-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Disapproved</p>
                            <p class="text-3xl font-bold text-slate-800"><?= $disapproved_requests ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Recent Requests</h2>
                        
                        <div class="overflow-x-auto bg-white rounded-xl border border-slate-200/80 shadow-sm">
                            <table class="min-w-full text-left">
                                <thead class="bg-slate-50/80 border-b border-slate-200/80">
                                    <tr>
                                        <th class="px-6 py-4 text-sm font-semibold text-slate-600">Requester</th>
                                        <th class="px-6 py-4 text-sm font-semibold text-slate-600">Purpose</th>
                                        <th class="px-6 py-4 text-sm font-semibold text-slate-600">Date</th>
                                        <th class="px-6 py-4 text-sm font-semibold text-slate-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200/80">
                                    <?php while($row = $recent_requests_query->fetch_assoc()): ?>
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="px-6 py-4 text-sm text-slate-700 font-medium"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($row['purpose']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= date('M d, Y', strtotime($row['start_date'])) ?></td>
                                        <td class="px-6 py-4">
                                            <?php
                                                $status = htmlspecialchars($row['status']);
                                                $badge_class = 'bg-slate-100 text-slate-800'; // Default
                                                if ($status == 'Pre-Approved') $badge_class = 'bg-yellow-100 text-yellow-800';
                                                if ($status == 'Approved') $badge_class = 'bg-green-100 text-green-800';
                                                if ($status == 'Disapproved') $badge_class = 'bg-red-100 text-red-800';
                                            ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $badge_class ?>"><?= $status ?></span>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Quick Actions</h2>
                        <div class="space-y-4">
                            <a href="requests.php" class="block w-full text-center p-6 bg-indigo-600 text-white rounded-xl shadow-lg hover:bg-indigo-700 transition-all duration-200 transform hover:-translate-y-1">
                                <h3 class="text-lg font-bold">Review All Requests</h3>
                                <p class="text-sm opacity-80 mt-1">View and manage all incoming requests.</p>
                            </a>
                            <a href="letter.php" class="block w-full text-center p-6 bg-white border border-slate-200/80 text-slate-800 rounded-xl shadow-sm hover:border-slate-300 hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                                <h3 class="text-lg font-bold">Generate Letter</h3>
                                <p class="text-sm text-slate-500 mt-1">Create a new official document.</p>
                            </a>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>


</body>
</html>