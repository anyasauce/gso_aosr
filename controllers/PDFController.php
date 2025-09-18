<?php
require __DIR__ . '/../vendor/autoload.php'; // adjust path
require_once '../config/init.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function generateLetter($fullname, $title, $date_time, $org, $address, $participants, $venue, $tp, $tc, $tr, $tt, $cn, $savePath = null) {
    $dateTimeObj = new DateTime($date_time);
    $formattedDate = $dateTimeObj->format('F j, Y \a\t g:i A'); // e.g., "September 18, 2025 at 3:30 PM"

    $data = [
        "fullname"     => $fullname,
        "title"        => $title,
        "date"         => $formattedDate,
        "org"          => $org,
        "address"      => $address,
        "participants" => $participants,
        "venue"        => $venue,
        "TP"           => $tp,
        "TC"           => $tc,
        "TR"           => $tr,
        "TT"           => $tt,
        "CN"           => $cn
    ];


    $html = file_get_contents(__DIR__ . '/../assets/templates/letter.html');

    foreach ($data as $key => $value) {
        $html = str_replace("{{{$key}}}", htmlspecialchars($value), $html);
    }

    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('Letter', 'portrait');
    $dompdf->render();

    if ($savePath) {
        // Save PDF to the specified path
        file_put_contents($savePath, $dompdf->output());
        return $savePath;
    } else {
        // Stream to browser
        return $dompdf->stream("Reservation_Letter.pdf", ["Attachment" => false]);
    }
}
