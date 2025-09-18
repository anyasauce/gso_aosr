<?php
// API Location: api/export_private_excel.php

// 1. Include Composer's Autoloader and your configuration
require_once '../../../vendor/autoload.php';
require_once '../../../config/init.php';

// Use the PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 2. Get the search term from the URL (if any)
$searchTerm = $_GET['search'] ?? '';

// 3. Build the SQL Query for 'private' requests
$sql = "SELECT * FROM requests WHERE type_gov = 'private'";
$params = [];

if (!empty($searchTerm)) {
    // Add conditions for all fields you want to be searchable
    $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR purpose LIKE ? OR event_name LIKE ? OR res_type LIKE ? OR status LIKE ? OR payment_status LIKE ?)";
    $likeTerm = "%{$searchTerm}%";
    array_push($params, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm);
}
$sql .= " ORDER BY start_date DESC";

// 4. Execute the Query using Prepared Statements
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// 5. Create the Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Private Requests Report');

// 6. Set the Header Row
$headers = [
    'Request ID', 'Reservation Type', 'Full Name', 'Email', 'Phone', 'Organization',
    'Purpose', 'Event Name', 'Start Date', 'End Date', 'Venue', 'Participants',
    'Vehicle Type', 'Passengers', 'Status', 'Payment Status', 'Payment Amount', 'Remarks', 'Date Submitted'
];
$sheet->fromArray($headers, NULL, 'A1');

// Style the header row
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4338CA']] // A slightly different blue
];
$sheet->getStyle('A1:S1')->applyFromArray($headerStyle);


// 7. Populate the data rows
$rowIndex = 2;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sheet->fromArray([
            $row['id'],
            $row['res_type'],
            $row['first_name'] . ' ' . $row['last_name'],
            $row['email'],
            $row['phone'],
            $row['org'],
            $row['purpose'],
            $row['event_name'],
            date("Y-m-d H:i", strtotime($row['start_date'])),
            date("Y-m-d H:i", strtotime($row['end_date'])),
            $row['res_place'],
            $row['num_person'],
            $row['v_type'],
            $row['num_pass'],
            $row['status'],
            $row['payment_status'],
            $row['payment_amount'],
            $row['remarks'],
            date("Y-m-d H:i", strtotime($row['created_at']))
        ], NULL, 'A' . $rowIndex);
        $rowIndex++;
    }
}

// Auto-size columns for better readability
foreach (range('A', 'S') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// 8. Set Headers to Force Download
$filename = 'Private_Requests_Report_' . date('Y-m-d') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// 9. Write the file to the browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$conn->close();
exit();