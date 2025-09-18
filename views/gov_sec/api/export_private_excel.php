<?php
// File: api/export_private_excel.php

// 1. Include Composer's Autoloader and your configuration
require_once '../../../vendor/autoload.php';
require_once '../../../config/init.php'; // or db.php if you're not using init.php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 2. Get the search term from the URL (if any)
$searchTerm = $_GET['search'] ?? '';

// 3. Build SQL query for pending private requests
$sql = "SELECT * FROM requests WHERE type_gov = 'private' AND status = 'Pending'";
$params = [];

if (!empty($searchTerm)) {
    $sql .= " AND (
        first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?
        OR purpose LIKE ? OR event_name LIKE ? OR res_type LIKE ? OR status LIKE ?
    )";

    $likeTerm = "%{$searchTerm}%";
    array_push($params, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm);
}

$sql .= " ORDER BY start_date DESC";

// 4. Execute the query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// 5. Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Pending Private Requests');

// 6. Set header row
$headers = [
    'Request ID', 'Reservation Type', 'Full Name', 'Email', 'Phone', 'Organization',
    'Purpose', 'Event Name', 'Start Date', 'End Date', 'Venue', 'Participants',
    'Vehicle Type', 'Passengers', 'Status', 'Payment Status', 'Payment Amount', 'Remarks', 'Date Submitted'
];
$sheet->fromArray($headers, NULL, 'A1');

// Style the header
$sheet->getStyle('A1:S1')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '0EA5E9'] // Sky-500 blue
    ]
]);

// 7. Fill in the data rows
$rowIndex = 2;
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
        date('Y-m-d H:i', strtotime($row['start_date'])),
        date('Y-m-d H:i', strtotime($row['end_date'])),
        $row['res_place'],
        $row['num_person'],
        $row['v_type'],
        $row['num_pass'],
        $row['status'],
        $row['payment_status'],
        $row['payment_amount'],
        $row['remarks'],
        date('Y-m-d H:i', strtotime($row['created_at']))
    ], NULL, 'A' . $rowIndex);
    $rowIndex++;
}

// Auto-size all columns for better readability
foreach (range('A', 'S') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// 8. Set download headers
$filename = 'Pending_Private_Requests_' . date('Y-m-d') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

// 9. Write to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$conn->close();
exit();
