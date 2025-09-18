<?php
require_once '../../config/db.php';
$requests = [];
// --- FIX: This query now ONLY fetches 'Pending' requests for this page ---
$sql = "SELECT * FROM requests WHERE type_gov = 'private' AND status = 'Pending' ORDER BY start_date DESC";
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
                    <h1 class="text-3xl font-bold text-slate-900">Pending Private Requests</h1>
                    <p class="text-slate-500 mt-1">Review and pre-approve new reservation requests.</p>
                </div>

                <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <table class="min-w-full text-left">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80">
                            <tr>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Requester</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Event / Purpose</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Approval Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Payment Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80">
                            <?php if (empty($requests)): ?>
                                <tr><td colspan="5" class="text-center py-10 px-6 text-slate-500">No pending requests found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($requests as $request): ?>
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="px-6 py-4 text-sm text-slate-700 font-medium"><?= htmlspecialchars($request['requester_name']) ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($request['display_event']) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                                <?= htmlspecialchars($request['status']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                             <?php
                                            $p_status = htmlspecialchars($request['payment_status']);
                                            $p_badge_class = 'bg-slate-100 text-slate-600'; // Default for Not Required
                                            if ($p_status === 'Pending Payment') $p_badge_class = 'bg-amber-100 text-amber-800';
                                            ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $p_badge_class ?>"><?= $p_status ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="details-btn px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-md hover:bg-slate-200" data-id="<?= $request['id'] ?>">Details</button>
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
            <div class="overflow-y-auto p-8">
                <div id="details-content" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6"></div>
            </div>
            <div class="flex-shrink-0 px-6 py-4 border-t mt-auto bg-slate-50 rounded-b-xl">
                <form id="action-form"></form>
            </div>
        </div>
    </div>

<script>
$(document).ready(function () {
    const modal = $('#details-modal');
    const detailsContent = $('#details-content');
    const closeModalBtn = $('#close-modal-btn');
    const modalActionForm = $('#action-form');

    $('.details-btn').on('click', function () {
        const requestId = $(this).data('id');
        detailsContent.html('<p class="text-center col-span-2">Loading...</p>');
        modalActionForm.empty();
        modal.removeClass('hidden').addClass('flex');

        $.ajax({
            url: 'api/manage_request.php', type: 'GET', dataType: 'json', data: { action: 'get_details', id: requestId },
            success: function (response) {
                if (!response.success) {
                    detailsContent.html(`<p class="text-red-500">${response.message}</p>`);
                    return;
                }
                const data = response.data;
                let content = '';
                const fieldMapping = {
                    'Request ID': data.id, 'Requester': `${data.first_name} ${data.last_name}`,
                    'Email': data.email, 'Phone': data.phone, 'Organization': data.org,
                    'Approval Status': `<span class="font-bold">${data.status}</span>`,
                    'Payment Status': `<span class="font-bold">${data.payment_status}</span>`,
                    'Payment Amount': data.payment_amount ? `₱${data.payment_amount}` : 'N/A',
                };
                for (const [label, value] of Object.entries(fieldMapping)) {
                    content += `<div><p class="text-sm text-slate-500">${label}</p><p class="font-semibold text-slate-800 break-words">${value || 'N/A'}</p></div>`;
                }
                detailsContent.html(content);

                // This logic is now perfect for this page, as it will only ever deal with 'Pending' requests.
                if (data.status === 'Pending') {
                    let isPaymentRequired = data.payment_status === 'Pending Payment' || parseFloat(data.payment_amount) > 0;
                    let amount = isPaymentRequired ? data.payment_amount : '';
                    const formHtml = `
                        <div class="space-y-4">
                            <div class="flex items-center"><input id="requires-payment" name="requires_payment" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600" ${isPaymentRequired ? 'checked' : ''}><label for="requires-payment" class="ml-3 block text-sm font-medium text-gray-700">Requires Payment</label></div>
                            <div id="payment-amount-container" class="${isPaymentRequired ? '' : 'hidden'}"><label for="payment-amount" class="block text-sm font-medium text-slate-600">Amount (PHP)</label><input type="number" name="amount" id="payment-amount" step="0.01" class="mt-1 w-full bg-white border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g., 500.00" value="${amount}"></div>
                        </div>
                        <div class="flex justify-end gap-3 pt-4 mt-4 border-t"><button type="button" class="action-btn px-4 py-2 bg-rose-500 text-white text-sm rounded-md" data-id="${data.id}" data-status="Disapproved">Reject</button><button type="submit" class="px-4 py-2 bg-emerald-500 text-white text-sm rounded-md">Save & Pre-Approve</button></div>
                    `;
                    modalActionForm.html(formHtml).data('id', data.id);
                } else {
                    modalActionForm.html('<p class="text-sm text-slate-500 text-center">No actions available for this request.</p>');
                }
            }
        });
    });

    $(document).on('change', '#requires-payment', function() {
        $('#payment-amount-container').toggleClass('hidden', !this.checked);
    });

    $(document).on('submit', '#action-form', function(e) {
        e.preventDefault();
        const requestId = $(this).data('id');
        const requiresPayment = $('#requires-payment').is(':checked');
        const amount = $('#payment-amount').val();

        if (requiresPayment && (!amount || amount <= 0)) {
            Swal.fire('Validation Error', 'Please enter a valid amount > 0.', 'error');
            return;
        }
        Swal.fire({
            title: 'Confirm Pre-Approval', text: "This will update the request and set payment details.", icon: 'info', showCancelButton: true, confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/manage_request.php', type: 'POST', dataType: 'json',
                    data: { action: 'pre_approve', id: requestId, requires_payment: requiresPayment, amount: requiresPayment ? amount : 0 },
                    success: function(response) {
                        if (response.success) { Swal.fire('Success!', response.message, 'success').then(() => location.reload()); } 
                        else { Swal.fire('Error!', response.message, 'error'); }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.action-btn', function() {
        // This handler now only needs to worry about the 'Disapproved' button on this page
        const newStatus = $(this).data('status');
        if (newStatus !== 'Disapproved') return;

        const requestId = $(this).data('id');
        Swal.fire({ title: 'Disapprove Request', text: 'Please provide a reason (optional):', input: 'textarea', showCancelButton: true, confirmButtonText: 'Confirm Disapproval' })
        .then((result) => {
            if (result.isConfirmed) { updateRequestStatus(requestId, newStatus, result.value || ''); }
        });
    });

    function updateRequestStatus(id, status, remarks = '') {
        $.ajax({
            url: 'api/manage_request.php', type: 'POST', dataType: 'json',
            data: { action: 'update_status', id: id, status: status, remarks: remarks },
            success: function (response) {
                if (response.success) { Swal.fire('Success!', response.message, 'success').then(() => location.reload()); } 
                else { Swal.fire('Error!', response.message, 'error'); }
            }
        });
    }
    
    closeModalBtn.on('click', () => modal.addClass('hidden').removeClass('flex'));
    modal.on('click', function(e) { if (e.target === this) { $(this).addClass('hidden').removeClass('flex'); }});
});
</script>
</body>
</html>