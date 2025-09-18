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



// Database connection
// Query last 2 months reservations
$sql = "
    SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) AS monthly_count
    FROM requests
    GROUP BY month
    ORDER BY month DESC
    LIMIT 2
";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Check we have at least 2 months
if (count($data) == 2) {
    $lastMonth = $data[0]['monthly_count'];    // most recent month
    $prevMonth = $data[1]['monthly_count'];    // month before

    $growth = $lastMonth - $prevMonth;         // difference between months
    $prediction = $lastMonth + $growth;

if ($prediction < 0) {
    // fallback: use average instead
    $sql_avg = "
        SELECT AVG(monthly_count) AS avg_requests
        FROM (
            SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) AS monthly_count
            FROM requests
            GROUP BY month
        ) AS monthly_data
    ";
    $avg_result = $conn->query($sql_avg)->fetch_assoc();
    $prediction = round($avg_result['avg_requests']);
}
       // forecast next month
} else {
    // Fallback: just use average if less than 2 months of data
    $sql_avg = "
        SELECT AVG(monthly_count) AS avg_requests
        FROM (
            SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) AS monthly_count
            FROM requests
            GROUP BY month
        ) AS monthly_data
    ";
    $avg_result = $conn->query($sql_avg)->fetch_assoc();
    $prediction = round($avg_result['avg_requests']);
}

// echo "📊 Predicted reservations for next month: " . $prediction;
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

     <div class="text-end mb-4">
        <button id="downloadPdf" 
          class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300 shadow">
          <!-- PDF Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" 
              class="h-5 w-5" fill="none" viewBox="0 0 24 24" 
              stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" 
              d="M19 21H5a2 2 0 01-2-2V5a2 2 0 
                012-2h7l5 5v11a2 2 0 01-2 2z" />
            <text x="9" y="16" font-size="6" fill="currentColor" font-family="Arial" font-weight="bold">PDF</text>
          </svg>

          Download as PDF
        </button>
    </div>



    <div id="main-report">
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
            <p class="text-sm font-medium text-slate-500">Predicted Reservations</p>
            <h2 class="text-4xl font-bold text-slate-900 mt-2"><?= htmlspecialchars($prediction) ?></h2>
          </div>
         <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-3 rounded-xl shadow-lg shadow-purple-500/30">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M19 9l-5 5-4-4-6 6" />
          </svg>
        </div>

        </div>
        <p class="text-sm text-slate-500 mt-4 flex items-center">
          Forecasted based on last months
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

          <div class="bg-white p-2 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-center items-start">
              <div class="mt-6 w-full">
                <canvas id="reservationsChart" height="150"></canvas>
              </div>
          </div>
        </div>

           <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-center items-start">
             <div class="mt-6">
              <canvas id="reservationsPieChart" height="200"></canvas>
            </div>
          </div>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
  const ctx = document.getElementById('reservationsChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Reservations',
        data: [12, 19, 3, 5, 2, 7], // <- replace with PHP values
        backgroundColor: 'rgba(99, 102, 241, 0.8)', // Indigo 500
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

   const pieCtx = document.getElementById('reservationsPieChart').getContext('2d');
  new Chart(pieCtx, {
    type: 'doughnut',
    data: {
      labels: ['Approved', 'Pending', 'Cancelled'], // example categories
      datasets: [{
        data: [45, 25, 30], // replace with PHP data if needed
        backgroundColor: [
          'rgba(99, 102, 241, 0.9)',   // Indigo
          'rgba(16, 185, 129, 0.9)',   // Emerald
          'rgba(239, 68, 68, 0.9)'     // Red
        ],
        borderWidth: 1,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { color: '#374151' } // Tailwind slate-700
        }
      }
    }
  });

document.getElementById('downloadPdf').addEventListener('click', async () => {
  const { jsPDF } = window.jspdf;

  // Target the main dashboard container
  const dashboard = document.getElementById('main-report');

  // Convert dashboard to canvas
  const canvas = await html2canvas(dashboard, { scale: 2 }); // sharp
  const imgData = canvas.toDataURL('image/png');

  // Create PDF
  const pdf = new jsPDF('p', 'mm', 'a4');
  const pdfWidth = pdf.internal.pageSize.getWidth();
  const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

  // Define margin (mm)
  const margin = 10; // 10mm all around

  // Adjust size to fit inside margins
  const usableWidth = pdfWidth - margin * 2;
  const usableHeight = (canvas.height * usableWidth) / canvas.width;

  pdf.addImage(imgData, 'PNG', margin, margin, usableWidth, usableHeight);
  pdf.save("dashboard-report.pdf");
});

</script>

</html> 