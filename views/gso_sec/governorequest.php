<?php
require_once '../../config/db.php';

$requests = [];
// --- 1. MODIFIED SQL QUERY ---
// Added 'payment_status' and 'payment_amount' to the SELECT statement.
$sql = "SELECT id, first_name, last_name, event_name, purpose, start_date, end_date, res_type, status, payment_status, payment_amount FROM requests WHERE type_gov = 'private' AND status = 'Pre-Approved' ORDER BY start_date DESC ";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['requester_name'] = $row['first_name'] . ' ' . $row['last_name'];
        $row['display_event'] = !empty($row['event_name']) ? $row['event_name'] : $row['purpose'];
        $row['start_date_formatted'] = date('M d, Y', strtotime($row['start_date']));
        $row['end_date_formatted'] = date('M d, Y', strtotime($row['end_date']));
        // Format the payment amount for display
        $row['payment_amount_formatted'] = is_numeric($row['payment_amount']) ? '₱' . number_format($row['payment_amount'], 2) : 'N/A';
        $requests[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php' ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />


<body class="bg-slate-50">
    <div class="flex">
        <?php include 'components/sidebar.php' ?>

        <div class="flex flex-col flex-1">
            <?php include 'components/header.php' ?>

            <main class="flex-1 p-6 lg:p-10">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900">Manage Requests</h1>
                    <p class="text-slate-500 mt-1">Review, approve, or reject reservation requests.</p>
                </div>

                <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <table id="governorTable" class="min-w-full text-left">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80">
                            <tr>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Requester</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Event / Purpose</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Date Range</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Payment Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Amount</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80">
                            <?php if (empty($requests)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-10 px-6 text-slate-500">No requests found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $request): ?>
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="px-6 py-4 text-sm text-slate-700 font-medium"><?= htmlspecialchars($request['requester_name']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($request['display_event']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($request['start_date_formatted']) ?> → <?= htmlspecialchars($request['end_date_formatted']) ?></td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $payment_status = htmlspecialchars($request['payment_status']);
                                            $p_badge_class = 'bg-slate-100 text-slate-800'; // Default
                                            if ($payment_status == 'Pending Payment') $p_badge_class = 'bg-yellow-100 text-yellow-800';
                                            if ($payment_status == 'Paid') $p_badge_class = 'bg-green-100 text-green-800';
                                            ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $p_badge_class ?>"><?= $payment_status ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600 font-mono"><?= htmlspecialchars($request['payment_amount_formatted']) ?></td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $status = htmlspecialchars($request['status']);
                                            $badge_class = 'bg-amber-100 text-amber-800';
                                            ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $badge_class ?>"><?= $status ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <button class="details-btn px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-md hover:bg-slate-200 transition-colors" data-id="<?= $request['id'] ?>">Details</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div id="details-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
            <div class="flex-shrink-0 flex justify-between items-center p-6 border-b">
                <h3 class="text-2xl font-bold text-slate-800">Request Details</h3>
                <button id="close-modal-btn" class="text-slate-400 hover:text-slate-800 text-3xl leading-none">&times;</button>
            </div>
            <div class="overflow-y-auto">
                <div id="map-container" class="hidden p-8 pt-0">
                    <p class="text-sm text-slate-500 mb-2">Destination Map</p>
                    <div id="details-map" class="w-full h-64 rounded-lg border z-10"></div>
                </div>
                <div id="details-content" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6"></div>
            </div>
            <div id="modal-footer" class="flex-shrink-0 flex justify-end gap-3 px-6 py-4 border-t mt-auto"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
    $(document).ready(function () {

        function getPlaceName(lat, lng) {
                return $.ajax({
                    url: `https://nominatim.openstreetmap.org/reverse`,
                    type: 'GET',
                    data: {
                        lat: lat,
                        lon: lng,
                        format: 'json'
                    }
                });
            }

        // Custom icons
const greenIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

const blueIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});




        const modal = $('#details-modal');
        const detailsContent = $('#details-content');
        const closeModalBtn = $('#close-modal-btn');
        const mapContainer = $('#map-container');
        const modalFooter = $('#modal-footer');
        let detailMap = null;

        $('.details-btn').on('click', function () {
            const requestId = $(this).data('id');
            detailsContent.html('<p class="text-center col-span-2">Loading details...</p>');
            mapContainer.addClass('hidden');
            modalFooter.empty();
            modal.removeClass('hidden').addClass('flex');

            $.ajax({
                url: 'api/manage_request.php',
                type: 'GET',
                dataType: 'json',
                data: { action: 'get_details', id: requestId },
                success: function (response) {
                    if (response.success) {
                        const data = response.data;
                        let content = '';
                        
                        // --- 4. MODIFIED MODAL CONTENT ---
                        // Added Payment Status and Amount to the details view.
                        const fieldMapping = {
                            'Request ID': data.id,
                            'Requester': `${data.first_name} ${data.last_name}`,
                            'Status': `<span class="font-bold">${data.status}</span>`,
                            'Payment Status': `<span class="font-bold">${data.payment_status}</span>`,
                            'Payment Amount': data.payment_amount ? `₱${parseFloat(data.payment_amount).toFixed(2)}` : 'N/A',
                             '<hr class="md:col-span-2 my-2 border-slate-200">': '',
                            'Event/Purpose': data.event_name || data.purpose,
                            'Start Date': new Date(data.start_date).toLocaleString(),
                            'End Date': new Date(data.end_date).toLocaleString(),
                        };

                        if (data.res_type === 'place') {
                            fieldMapping['Venue'] = data.res_place;
                            fieldMapping['Participants'] = data.num_person;
                        } else {
                            mapContainer.removeClass('hidden');
                            setTimeout(() => initializeDetailMap(data.latitude, data.longitude), 100);
                        }
                        
                        for (const [label, value] of Object.entries(fieldMapping)) {
                            if (label.startsWith('<hr')) {
                                content += label;
                            } else {
                                content += `<div><p class="text-sm text-slate-500">${label}</p><p class="font-semibold text-slate-800 break-words">${value || 'N/A'}</p></div>`;
                            }
                        }
                        detailsContent.html(content);

                        // --- 5. UPDATED MODAL FOOTER LOGIC ---
                        // Modified logic for payment handling with PayMongo integration.
                        const rejectBtn = `<button class="reject-btn px-4 py-2 bg-rose-500 text-white text-sm font-semibold rounded-md hover:bg-rose-600" data-id="${data.id}">Reject</button>`;
                        
                        if (data.status === 'Pre-Approved') {
                            if (data.payment_status === 'Not Required') {
                                // No payment required, show approve button
                                const approveBtn = `<button class="approve-btn px-4 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-md hover:bg-emerald-600" data-id="${data.id}">Approve</button>`;
                                modalFooter.html(approveBtn + rejectBtn);
                            } else if (data.payment_status === 'Pending Payment' || !data.payment_status) {
                                // Payment is pending, show "Send Payment Link"
                                const sendPaymentBtn = `<button class="send-payment-btn px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-md hover:bg-blue-600" data-id="${data.id}">Send Payment Link</button>`;
                                const markPaidBtn = `<button class="mark-paid-btn px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-md hover:bg-green-600" data-id="${data.id}">Mark as Paid</button>`;
                                modalFooter.html(sendPaymentBtn + markPaidBtn + rejectBtn);
                            } else if (data.payment_status === 'Paid') {
                                // Payment is complete, show approve button
                                const approveBtn = `<button class="approve-btn px-4 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-md hover:bg-emerald-600" data-id="${data.id}">Approve</button>`;
                                modalFooter.html(approveBtn + rejectBtn);
                            }
                        }

                    } else {
                        detailsContent.html(`<p class="text-red-500">${response.message}</p>`);
                    }
                },
                error: function () {
                    detailsContent.html('<p class="text-red-500">Could not load details.</p>');
                }
            });
        });
        
        // --- 6. NEW 'SEND PAYMENT LINK' EVENT HANDLER ---
        $(document).on('click', '.send-payment-btn', function() {
            const requestId = $(this).data('id');
            Swal.fire({
                title: 'Send Payment Link', 
                text: "This will create a PayMongo payment link and send it to the requester's email. Continue?", 
                icon: 'question',
                showCancelButton: true, 
                confirmButtonColor: '#3b82f6', 
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, send payment link!'
            }).then((result) => {
                if (result.isConfirmed) {
                    sendPaymentLink(requestId);
                }
            });
        });
        
        // --- 7. UPDATED 'MARK AS PAID' EVENT HANDLER (for manual verification) ---
        $(document).on('click', '.mark-paid-btn', function() {
            const requestId = $(this).data('id');
            Swal.fire({
                title: 'Confirm Payment', 
                text: "Are you sure you want to manually mark this request as paid? Use this only if you've verified payment outside the system.", 
                icon: 'warning',
                showCancelButton: true, 
                confirmButtonColor: '#10b981', 
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, mark as paid!'
            }).then((result) => {
                if (result.isConfirmed) {
                    updatePaymentStatus(requestId, 'Paid');
                }
            });
        });
        
        // --- 8. NEW AJAX FUNCTION FOR SENDING PAYMENT LINK ---
        function sendPaymentLink(id) {
            $.ajax({
                url: 'api/manage_request.php', 
                type: 'POST', 
                dataType: 'json',
                data: { action: 'send_payment_link', id: id },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ 
                            title: 'Payment Link Sent!', 
                            text: response.message, 
                            icon: 'success', 
                            timer: 3000, 
                            showConfirmButton: false 
                        }).then(() => {
                            modal.addClass('hidden').removeClass('flex'); // Close modal
                            // Re-open the modal to show updated status
                            $(`.details-btn[data-id="${id}"]`).click();
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Could not connect to the server.', 'error');
                }
            });
        }
        
        // --- 9. UPDATED AJAX FUNCTION FOR PAYMENT STATUS ---
        function updatePaymentStatus(id, paymentStatus) {
            $.ajax({
                url: 'api/manage_request.php', 
                type: 'POST', 
                dataType: 'json',
                data: { action: 'update_payment', id: id, payment_status: paymentStatus },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ 
                            title: 'Success!', 
                            text: `Request has been marked as ${paymentStatus}.`, 
                            icon: 'success', 
                            timer: 2000, 
                            showConfirmButton: false 
                        }).then(() => {
                            modal.addClass('hidden').removeClass('flex'); // Close modal
                            // Re-open the modal to show the updated "Approve" button
                            $(`.details-btn[data-id="${id}"]`).click();
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Could not connect to the server.', 'error');
                }
            });
        }
        
        function initializeDetailMap(lat, lng) {
    const capitol = [10.7040, 122.5621]; // Iloilo Provincial Capitol

    if (detailMap) {
        detailMap.setView(capitol, 13);
    } else {
        detailMap = L.map('details-map').setView(capitol, 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(detailMap);
    }

    // Clear old route if any
    if (detailMap._routingControl) {
        detailMap.removeControl(detailMap._routingControl);
    }

    // Add route with thick green line
    detailMap._routingControl = L.Routing.control({
        waypoints: [
            L.latLng(capitol[0], capitol[1]),
            L.latLng(lat, lng)
        ],
        routeWhileDragging: false,
        show: false,
        addWaypoints: false,
        lineOptions: {
            styles: [{ color: 'green', weight: 6, opacity: 0.8 }]
        }
    }).addTo(detailMap);

    // Add markers
    L.marker(capitol, { icon: greenIcon }).addTo(detailMap)
        .bindPopup(`<b>Iloilo Provincial Capitol</b>`).openPopup();

    L.marker([lat, lng], { icon: blueIcon }).addTo(detailMap)
        .bindPopup(`Requested Destination`).openPopup();

    setTimeout(() => detailMap.invalidateSize(), 200);
}
    


        $(document).on('click', '.approve-btn', function() {
            const requestId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?', text: "You are about to approve this request.", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#16a34a', cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateRequestStatus(requestId, 'Approved');
                }
            });
        });

        $(document).on('click', '.reject-btn', function() {
            const requestId = $(this).data('id');
            Swal.fire({
                title: 'Reject Request', text: 'Please provide a reason for rejection (optional):',
                input: 'textarea', inputPlaceholder: 'Type your reason here...', showCancelButton: true,
                confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b', confirmButtonText: 'Confirm Rejection'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateRequestStatus(requestId, 'Disapproved', result.value || '');
                }
            });
        });

        function updateRequestStatus(id, status, remarks = '') {
            $.ajax({
                url: 'api/manage_request.php', type: 'POST', dataType: 'json',
                data: { action: 'update_status', id: id, status: status, remarks: remarks },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ title: 'Success!', text: `Request has been ${status}.`, icon: 'success', timer: 2000, showConfirmButton: false })
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Could not connect to the server.', 'error');
                }
            });
        }

        closeModalBtn.on('click', () => modal.addClass('hidden').removeClass('flex'));
        modal.on('click', function (e) {
            if (e.target === this) {
                $(this).addClass('hidden').removeClass('flex');
            }
        });
    });
    </script>
</body>
</html>