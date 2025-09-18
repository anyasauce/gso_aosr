<?php 
include '../../config/init.php';

$stmt = $conn->prepare("SELECT COUNT(*) AS total_reservations FROM requests");
$stmt->execute();
$total_reservation = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT COUNT(*) AS total_venue FROM requests WHERE res_type = 'place'");
$stmt->execute();
$total_venue = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT COUNT(*) AS dispatch_vehicle FROM vehicles WHERE NOT `availability` = 'available'");
$stmt->execute();
$dispatch_vehicle = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT COUNT(*) AS pending_request FROM requests WHERE status = 'pending'");
$stmt->execute();
$pending_request = $stmt->get_result()->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php' ?>
<body class="bg-slate-50 text-slate-800">
  <div class="flex">
    <?php include 'components/sidebar.php' ?>

    <div class="flex flex-col flex-1">
      <?php include 'components/header.php' ?>

      <main class="flex-1 p-6 lg:p-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-slate-500 mt-1">Here's a summary of your activities.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          
          <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm font-medium text-slate-500">Total Reservations</p>
                <h2 class="text-4xl font-bold text-slate-900 mt-2"><?=htmlspecialchars($total_reservation['total_reservations'])?></h2>
              </div>
              <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-3 rounded-xl shadow-lg shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
              </div>
            </div>
            <p class="text-sm text-green-500 mt-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L12 11.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0L12 12.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
              12% from last month
            </p>
          </div>

          <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm font-medium text-slate-500">Venues Booked</p>
                <h2 class="text-4xl font-bold text-slate-900 mt-2"><?=htmlspecialchars($total_venue['total_venue'])?></h2>
              </div>
              <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white p-3 rounded-xl shadow-lg shadow-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>
            <p class="text-sm text-green-500 mt-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L12 11.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0L12 12.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
              5 new venues this week
            </p>
          </div>

          <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm font-medium text-slate-500">Vehicles Dispatched</p>
                <h2 class="text-4xl font-bold text-slate-900 mt-2"><?=htmlspecialchars($dispatch_vehicle['dispatch_vehicle'])?></h2>
              </div>
              <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white p-3 rounded-xl shadow-lg shadow-amber-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /> <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
            </div>
            <p class="text-sm text-red-500 mt-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L12 8.414l3.293 3.293a1 1 0 001.414-1.414l-4-4a1 1 0 00-1.414 0L12 7.586 7.707 3.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0z" clip-rule="evenodd" /></svg>
              -2% from yesterday
            </p>
          </div>

          <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm font-medium text-slate-500">Pending Approvals</p>
                <h2 class="text-4xl font-bold text-slate-900 mt-2"><?=htmlspecialchars($pending_request['pending_request'])?></h2>
              </div>
              <div class="bg-gradient-to-br from-rose-500 to-rose-600 text-white p-3 rounded-xl shadow-lg shadow-rose-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <p class="text-sm text-slate-500 mt-4 flex items-center">
              Action required
            </p>
          </div>

        </div>

         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
          <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm font-medium text-slate-500">Total Reservations</p>
                <h2 class="text-4xl font-bold text-slate-900 mt-2"><?=htmlspecialchars($total_reservation['total_reservations'])?></h2>
              </div>
              <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-3 rounded-xl shadow-lg shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
              </div>
            </div>
            <p class="text-sm text-green-500 mt-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L12 11.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0L12 12.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
              12% from last month
            </p>
          </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm mt-8">
          <div class="px-6 py-5 border-b border-slate-200/80 flex justify-between items-center">
            <h5 class="text-lg font-semibold text-slate-900">Recent Reservations</h5>
            <button class="px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40">
              View All
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="text-left text-slate-500">
                <tr>
                  <th class="px-6 py-4 font-semibold">Requestor</th>
                  <th class="px-6 py-4 font-semibold">Asset</th>
                  <th class="px-6 py-4 font-semibold">Date</th>
                  <th class="px-6 py-4 font-semibold">Status</th>
                  <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200/80">
                <tr class="hover:bg-slate-50/80">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <img src="https://ui-avatars.com/api/?name=Juan+Dela+Cruz&background=818cf8&color=fff" class="w-9 h-9 rounded-full mr-3 object-cover">
                      <div>
                        <p class="font-semibold text-slate-900">Juan Dela Cruz</p>
                        <p class="text-slate-500">juandelacruz@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-slate-600">Iloilo Convention Center</td>
                  <td class="px-6 py-4 whitespace-nowrap text-slate-600">Sep 25, 2025</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-full">
                      Approved
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <button class="p-2 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-200/60 transition-colors duration-200">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                  </td>
                </tr>
                <tr class="hover:bg-slate-50/80">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <img src="https://ui-avatars.com/api/?name=Maria+Clara&background=f59e0b&color=fff" class="w-9 h-9 rounded-full mr-3 object-cover">
                      <div>
                        <p class="font-semibold text-slate-900">Maria Clara</p>
                        <p class="text-slate-500">mariaclara@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-slate-600">Toyota Hilux (SGS-123)</td>
                  <td class="px-6 py-4 whitespace-nowrap text-slate-600">Sep 22, 2025</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium text-amber-700 bg-amber-100 rounded-full">
                      Pending
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <button class="p-2 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-200/60 transition-colors duration-200">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                  </td>
                </tr>
                 <tr class="hover:bg-slate-50/80">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <img src="https://ui-avatars.com/api/?name=Jose+Rizal&background=f43f5e&color=fff" class="w-9 h-9 rounded-full mr-3 object-cover">
                      <div>
                        <p class="font-semibold text-slate-900">Jose Rizal</p>
                        <p class="text-slate-500">joserizal@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-slate-600">Freedom Grandstand</td>
                  <td class="px-6 py-4 whitespace-nowrap text-slate-600">Sep 19, 2025</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium text-rose-700 bg-rose-100 rounded-full">
                      Cancelled
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <button class="p-2 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-200/60 transition-colors duration-200">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html> 