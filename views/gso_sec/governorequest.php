<?php
require_once '../../config/db.php';

$requests = [];
$sql = "SELECT * FROM requests WHERE type_gov = 'private' AND status = 'Pre-Approved' ORDER BY start_date DESC ";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['requester_name'] = $row['first_name'] . ' ' . $row['last_name'];
        $row['display_event'] = !empty($row['event_name']) ? $row['event_name'] : $row['purpose'];
        $row['start_date_formatted'] = date('M d, Y', strtotime($row['start_date']));
        $row['end_date_formatted'] = date('M d, Y', strtotime($row['end_date']));
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <table class="min-w-full text-left">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80">
                            <tr>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Requester</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Event / Purpose</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Date Range</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Reservation Type</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80">
                            <?php if (empty($requests)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-10 px-6 text-slate-500">No requests found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $request): ?>
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="px-6 py-4 text-sm text-slate-700 font-medium"><?= htmlspecialchars($request['requester_name']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($request['display_event']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($request['start_date_formatted']) ?> → <?= htmlspecialchars($request['end_date_formatted']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($request['res_type']) ?></td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $status = htmlspecialchars($request['status']);
                                            $badge_class = 'bg-amber-100 text-amber-800'; // Default to Pending
                                            if ($status == 'Approved') $badge_class = 'bg-emerald-100 text-emerald-800';
                                            if ($status == 'Disapproved') $badge_class = 'bg-rose-100 text-rose-800';
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
                <div id="details-content" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    </div>
            </div>

            <div id="modal-footer" class="flex-shrink-0 flex justify-end gap-3 px-6 py-4 border-t mt-auto">
                </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        const modal = $('#details-modal');
        const detailsContent = $('#details-content');
        const closeModalBtn = $('#close-modal-btn');
        const mapContainer = $('#map-container');
        const modalFooter = $('#modal-footer');
        let detailMap = null; // Variable to hold the map instance

        // --- VIEW DETAILS ---
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
                        const fieldMapping = {
                            'Request ID': data.id,
                            'Requester': `${data.first_name} ${data.last_name}`,
                            'Email': data.email,
                            'Phone': data.phone,
                            'Organization': data.org,
                            'Status': `<span class="font-bold">${data.status}</span>`,
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

                        if (data.status === 'Pre-Approved') {
                            const approveBtn = `<button class="approve-btn px-4 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-md hover:bg-emerald-600" data-id="${data.id}">Approve</button>`;
                            const rejectBtn = `<button class="reject-btn px-4 py-2 bg-rose-500 text-white text-sm font-semibold rounded-md hover:bg-rose-600" data-id="${data.id}">Reject</button>`;
                            modalFooter.html(approveBtn + rejectBtn);
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
        
        // --- FUNCTION TO INITIALIZE THE MAP IN THE MODAL ---
        function initializeDetailMap(lat, lng) {
            // If the map is already initialized, just set the new view
            if (detailMap) {
                detailMap.setView([lat, lng], 15);
            } else { // Otherwise, create a new map instance
                detailMap = L.map('details-map').setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(detailMap);
            }
            // Add a marker to the destination
            L.marker([lat, lng]).addTo(detailMap)
                .bindPopup('Requested Destination')
                .openPopup();
                
            // IMPORTANT: Invalidate the map size to ensure it renders correctly
            setTimeout(() => detailMap.invalidateSize(), 10);
        }

        // --- EVENT DELEGATION FOR DYNAMICALLY ADDED BUTTONS ---
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

        // --- AJAX UPDATE FUNCTION ---
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

        // --- Modal Closing Logic ---
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