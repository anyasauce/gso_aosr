<?php
header('Content-Type: application/json');

include 'config/init.php';
$sql = "SELECT start_date, end_date FROM requests WHERE status = 'Approved' AND res_type = 'place'";
$result = $conn->query($sql);

$reservedDates = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $startDate = new DateTime($row['start_date']);
        $endDate = new DateTime($row['end_date']);
        
        while ($startDate <= $endDate) {
            $reservedDates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }
    }
}

$reservedDates = array_unique($reservedDates);

echo json_encode(array_values($reservedDates));
?>