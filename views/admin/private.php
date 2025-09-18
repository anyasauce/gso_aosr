<?php

require_once '../../config/init.php'; // Use init for consistent setup

// Fetch all records once for the page
$sql = "SELECT * FROM requests WHERE type_gov = 'private' ORDER BY start_date DESC";
$result = $conn->query($sql);

// Store all records in an array for JavaScript to use
$all_records = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Office Requests</title>

    <?php include 'components/head.php'; // Includes base CSS and fonts ?>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <style>
        /* ✅ Custom styles to make DataTables match the new design */
        .dataTables_wrapper {
            padding: 1.5rem;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .dataTables_filter input {
            width: 100%;
            max-width: 300px;
            padding: 0.6rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        .dataTables_filter input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgb(79 70 229 / 0.2);
            outline: none;
        }
        .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
        }
        .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            margin: 0 2px;
            border-radius: 0.375rem;
        }
        .dataTables_paginate .paginate_button.current {
            background-color: #4f46e5;
            color: white !important;
            border: 1px solid #4f46e5;
        }
        .dataTables_paginate .paginate_button:hover {
            background-color: #e0e7ff;
            border-color: #c7d2fe;
        }
    </style>
</head>
<body class="bg-slate-100">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden"></div>
    <div class="relative min-h-screen lg:flex">
        
        <?php include 'components/sidebar.php'; ?>

        <div class="flex-1 flex flex-col">
            <?php include 'components/header.php'; ?>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Private Sector Requests</h1>
                        <p class="text-slate-500 mt-1">Review and manage all requests from private entities.</p>
                    </div>
                    <button id="export-excel-btn" class="mt-4 sm:mt-0 flex items-center gap-2 bg-emerald-600 text-white font-semibold px-4 py-2 rounded-lg shadow-lg hover:bg-emerald-700 transition active:scale-95">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.25H8a.75.75 0 000 1.5h1.25v1.25a.75.75 0 001.5 0v-1.25H12a.75.75 0 000-1.5h-1.25V2.75z"></path><path fill-rule="evenodd" d="M2 1a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V3a2 2 0 00-2-2H2zm1.5 12.5a.5.5 0 000-1H2a.5.5 0 000 1h1.5zm0-2a.5.5 0 000-1H2a.5.5 0 000 1h1.5zM2 9.5a.5.5 0 01.5-.5h1.5a.5.5 0 010 1H2.5a.5.5 0 01-.5-.5zm.5 2.5a.5.5 0 000-1H2a.5.5 0 000 1h1.5zM2 5.5a.5.5 0 01.5-.5h1.5a.5.5 0 010 1H2.5a.5.5 0 01-.5-.5zM14 14a.5.5 0 01-.5.5h-1.5a.5.5 0 010-1h1.5a.5.5 0 01.5.5zm.5-2.5a.5.5 0 000-1h-1.5a.5.5 0 000 1h1.5zM14 9.5a.5.5 0 01-.5.5h-1.5a.5.5 0 010-1h1.5a.5.5 0 01.5.5zm.5-2.5a.5.5 0 000-1h-1.5a.5.5 0 000 1h1.5zM14 3.5a.5.5 0 01-.5.5h-1.5a.5.5 0 010-1h1.5a.5.5 0 01.5.5z" clip-rule="evenodd"></path></svg>
                        Export Full Report
                    </button>
                </div>

                <div class="bg-white shadow-lg rounded-xl">
                    <table id="privateTable" class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr class="border-b border-slate-200">
                                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Requested By</th>
                                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Event Date</th>
                                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <?php if (!empty($all_records)): ?>
                                <?php foreach ($all_records as $row): ?>
                                    <?php
                                        $fullName = htmlspecialchars($row["first_name"]) . ' ' . htmlspecialchars($row["last_name"]);
                                        $status = htmlspecialchars($row["status"]);
                                        $paymentStatus = htmlspecialchars($row["payment_status"]);

                                        $status_badge = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                                        if ($status === 'Approved') $status_badge = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                        elseif ($status === 'Disapproved') $status_badge = 'bg-rose-100 text-rose-800 border-rose-200';
                                        
                                        $payment_badge = 'bg-slate-100 text-slate-800 border-slate-200';
                                        if ($paymentStatus === 'Pending Payment') $payment_badge = 'bg-amber-100 text-amber-800 border-amber-200';
                                        elseif ($paymentStatus === 'Paid') $payment_badge = 'bg-green-100 text-green-800 border-green-200';
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-800 capitalize"><?= htmlspecialchars($row["res_type"]) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-600"><?= $fullName ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-600"><?= date("M d, Y", strtotime($row["start_date"])) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border <?= $payment_badge ?>"><?= $paymentStatus ?></span></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border <?= $status_badge ?>"><?= $status ?></span></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button data-record='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>' class="details-btn bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-10 text-slate-500">No private sector requests found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div id="details-modal" class="fixed inset-0 bg-black/60 z-50 flex justify-center items-center p-4 hidden">
        <div id="modal-content" class="bg-white rounded-2xl shadow-xl w-full max-w-2xl transform transition-all -translate-y-10 opacity-0">
            <form id="update-form" method="POST">
                <input type="hidden" name="id" id="modal_request_id">
                <input type="hidden" name="action" id="modal_action" value="">
                
                <div class="flex justify-between items-center p-5 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-100 p-2 rounded-full">
                           <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800">Request Details</h3>
                    </div>
                    <button type="button" class="close-modal-btn text-slate-400 hover:text-slate-600 text-3xl font-light">&times;</button>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 max-h-[65vh] overflow-y-auto">
                    <?php function detail_item($label, $id, $extra_classes = '') {
                        echo "<div class='{$extra_classes}'><p class='text-sm font-semibold text-slate-500'>{$label}</p><p id='{$id}' class='text-slate-800'></p></div>";
                    } ?>
                    
                    <div class="sm:col-span-2"><?php detail_item('Reservation Type / Purpose', 'modal_purpose'); ?></div>
                    <?php detail_item('Requester', 'modal_requester'); ?>
                    <?php detail_item('Organization', 'modal_org'); ?>
                    <?php detail_item('Contact Email', 'modal_email'); ?>
                    <?php detail_item('Contact Phone', 'modal_phone'); ?>
                    <?php detail_item('Event Start', 'modal_start_date'); ?>
                    <?php detail_item('Event End', 'modal_end_date'); ?>
                    <?php detail_item('Venue', 'modal_res_place'); ?>
                    <?php detail_item('Participants', 'modal_num_person'); ?>
                    <div class="sm:col-span-2 border-t pt-4 mt-2"><?php detail_item('Payment Status', 'modal_payment_status'); ?></div>
                    <?php detail_item('Payment Amount', 'modal_payment_amount'); ?>

                    <div class="sm:col-span-2 pt-5 mt-5 border-t border-slate-200">
                        <label for="modal_status" class="block text-sm font-semibold text-slate-700 mb-2">Update Status</label>
                        <select id="modal_status" name="status" class="block w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                            <option value="Pre-Approved">Pre-Approved</option>
                            <option value="Approved">Approved</option>
                            <option value="Disapproved">Disapproved</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="modal_remarks" class="block text-sm font-semibold text-slate-700 mb-2">Remarks (Optional)</label>
                        <textarea id="modal_remarks" name="remarks" rows="3" class="block w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" placeholder="Add a reason for approval or disapproval..."></textarea>
                    </div>
                </div>
                
                <div id="modal-footer" class="flex flex-wrap justify-end items-center p-4 bg-slate-50 border-t border-slate-200 gap-3">
                    </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            };
            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarOverlay?.addEventListener('click', toggleSidebar);
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    $(document).ready(function () {
        // ✅ Assign the DataTable instance to a variable
        const table = $('#privateTable').DataTable({
            "pagingType": "simple_numbers",
            "language": {
                "search": "",
                "searchPlaceholder": "Search requests...",
                "lengthMenu": "Show _MENU_ entries"
            }
        });

        const modal = $('#details-modal');
        const modalContent = $('#modal-content');
        const modalFooter = $('#modal-footer');
        const updateForm = $('#update-form');

        // --- 1. MODAL LOGIC ---
        $('#privateTable tbody').on('click', '.details-btn', function () {
            const record = JSON.parse($(this).attr('data-record'));

            // Populate modal fields
            $('#modal_request_id').val(record.id);
            $('#modal_purpose').text(record.res_type === 'vehicle' ? record.purpose : (record.event_name || record.purpose));
            $('#modal_requester').text(record.first_name + ' ' + record.last_name);
            $('#modal_org').text(record.org || 'N/A');
            $('#modal_email').text(record.email);
            $('#modal_phone').text(record.phone);
            $('#modal_start_date').text(new Date(record.start_date).toLocaleString());
            $('#modal_end_date').text(new Date(record.end_date).toLocaleString());
            $('#modal_res_place').text(record.res_place || 'N/A for Vehicle');
            $('#modal_num_person').text(record.num_person || 'N/A');
            $('#modal_payment_status').text(record.payment_status);
            $('#modal_payment_amount').text(record.payment_amount ? '₱' + parseFloat(record.payment_amount).toFixed(2) : 'N/A');
            $('#modal_status').val(record.status);
            $('#modal_remarks').val(record.remarks);

            // Generate modal footer buttons
            generateFooterButtons(record);

            // Show modal with animation
            modal.removeClass('hidden');
            setTimeout(() => modalContent.removeClass('-translate-y-10 opacity-0'), 50);
            $('body').addClass('overflow-hidden');
        });

        // --- 2. EXPORT BUTTON LOGIC ---
        $('#export-excel-btn').on('click', function () {
            const currentSearch = table.search(); // ✅ This now works
            const exportUrl = `api/export_private_excel.php?search=${encodeURIComponent(currentSearch)}`;
            window.location.href = exportUrl;
        });

        // --- 3. FUNCTION TO GENERATE FOOTER BUTTONS ---
        function generateFooterButtons(record) {
            modalFooter.empty(); // Clear existing buttons

            const closeBtn = `<button type="button" class="close-modal-btn bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-2 px-5 rounded-lg transition duration-150">Close</button>`;

            let actionButtons = '';
            if (record.status === 'Pre-Approved' && record.payment_status === 'Pending Payment') {
                actionButtons += `<button type="button" class="action-btn bg-sky-500 hover:bg-sky-600 text-white" data-action="send_payment_link">Send Payment Link</button>`;
            }
            actionButtons += `<button type="submit" class="action-btn bg-emerald-600 hover:bg-emerald-700 text-white" data-action="update_status">Save Changes</button>`;

            modalFooter.html(closeBtn + actionButtons);

            // Style the action buttons
            $('.action-btn').addClass('font-semibold py-2 px-5 rounded-lg transition duration-150 flex items-center gap-2');
        }

        // --- 4. FORM SUBMISSION HANDLER ---
        updateForm.on('submit', function (e) {
            e.preventDefault();

            const action = $(document.activeElement).data('action') || 'update_status';
            $('#modal_action').val(action);

            let formData = $(this).serialize();

            $.ajax({
                url: 'api/manage_request.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function (response) {
                    closeModal();
                    Swal.fire({
                        icon: response.success ? 'success' : 'error',
                        title: response.success ? 'Success!' : 'Error!',
                        text: response.message,
                        timer: 2500,
                        showConfirmButton: false
                    }).then(() => {
                        if (response.success) location.reload();
                    });
                },
                error: function () {
                    Swal.fire('Error!', 'Could not connect to the server.', 'error');
                }
            });
        });

        // --- 5. DYNAMIC BUTTON CLICK (NO LOGIC HERE, JUST TO ALLOW SUBMIT HANDLER TO CATCH) ---
        modalFooter.on('click', '.action-btn', function () {
            // Let the submit handler handle it
        });

        // --- 6. CLOSE MODAL LOGIC ---
        function closeModal() {
            modalContent.addClass('-translate-y-10 opacity-0');
            setTimeout(() => modal.addClass('hidden'), 300);
            $('body').removeClass('overflow-hidden');
        }

        // Close button and background click to close
        $(document).on('click', '.close-modal-btn', closeModal);
        modal.on('click', function (e) {
            if ($(e.target).is(modal)) closeModal();
        });
    });
</script>

</body>
</html>