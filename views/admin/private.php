<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php'; ?>

<head>
    <style>
        /* Simple transition for modal fade-in */
        .modal {
            transition: opacity 0.25s ease;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <div class="flex flex-col flex-1 h-screen overflow-y-auto">
            <?php include 'components/header.php'; ?>

            <main class="p-4 sm:p-6 md:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Private Office Requests</h1>
                    </div>

                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr class="border-b border-gray-200">
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Event Name</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Requested By</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Event Date</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                include '../../config/init.php';
                                $sql = "SELECT * FROM requests WHERE type_gov = 'private'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $record_index = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $fullName = htmlspecialchars($row["first_name"]) . ' ' . htmlspecialchars($row["last_name"]);
                                        $status = htmlspecialchars($row["status"]);

                                        $badge_color = 'bg-yellow-100 text-yellow-800';
                                        if ($status === 'Approved') {
                                            $badge_color = 'bg-green-100 text-green-800';
                                        } elseif ($status === 'Disapproved') {
                                            $badge_color = 'bg-red-100 text-red-800';
                                        }
                                ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= htmlspecialchars($row["event_name"] ?? '') ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?=  $fullName ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?= date("M d, Y", strtotime($row["start_date"])) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badge_color ?>">
                                                    <?= $status ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <button onclick="openModal(<?= $record_index ?>)" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                        $all_records[] = $row;
                                        $record_index++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center py-10 text-gray-500'>No private office requests found.</td></tr>";
                                }
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php if (!empty($all_records)) : ?>
        <?php foreach ($all_records as $index => $record) : ?>
            <div id="modal-<?= $index ?>" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4 opacity-0 pointer-events-none">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all scale-95">
                    <div class="flex justify-between items-center p-5 border-b">
                        <h3 class="text-xl font-semibold text-gray-800">Request Details</h3>
                        <button onclick="closeModal(<?= $index ?>)" class="text-gray-400 hover:text-gray-600 text-3xl font-light">&times;</button>
                    </div>
                    <form action="../../controllers/CapitolController.php" method="POST">
                        <input type="hidden" name="request_id" value="<?= $record['id'] ?>">
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 max-h-[70vh] overflow-y-auto">
                            <div class="sm:col-span-2">
                                <p class="font-bold text-gray-700">Event Name</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['event_name']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Requester</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['first_name']) . ' ' . htmlspecialchars($record['last_name']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Organization</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['org']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Contact Email</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['email']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Contact Phone</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['phone']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Event Start</p>
                                <p class="text-gray-600"><?= date("F j, Y, g:i A", strtotime($record['start_date'] . ' ' . $record['start_time'])) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Event End</p>
                                <p class="text-gray-600"><?= date("F j, Y, g:i A", strtotime($record['end_date'] . ' ' . $record['end_time'])) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Reservation Place</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['res_place']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Number of People</p>
                                <p class="text-gray-600"><?= htmlspecialchars($record['num_person']) ?></p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="font-bold text-gray-700">Purpose</p>
                                <p class="text-gray-600 text-justify"><?= htmlspecialchars($record['purpose']) ?></p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="font-bold text-gray-700">Additional Notes</p>
                                <p class="text-gray-600 text-justify"><?= htmlspecialchars($record['add_notes']) ?></p>
                            </div>

                            <div class="sm:col-span-2 pt-4 mt-4 border-t">
                                    <label for="status-<?= $index ?>" class="block font-bold text-gray-700 mb-2">Update Status</label>
                                    <select id="status-<?= $index ?>" name="status" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                        <option value="Pending" <?= ($record['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                        <option value="Approved" <?= ($record['status'] == 'Approved') ? 'selected' : '' ?>>Approved</option>
                                        <option value="Disapproved" <?= ($record['status'] == 'Disapproved') ? 'selected' : '' ?>>Disapproved</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="remarks-<?= $index ?>" class="block font-bold text-gray-700 mb-2">Remarks (Optional)</label>
                                    <textarea id="remarks-<?= $index ?>" name="remarks" rows="3" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" placeholder="Add a reason for approval or disapproval..."><?= htmlspecialchars($record['remarks']) ?></textarea>
                                </div>
                    </div>
                    <div class="flex justify-end items-center p-4 bg-gray-50 border-t">
                        <button onclick="closeModal(<?= $index ?>)" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-5 rounded-md transition duration-150">Close</button>
                        <button type="submit" name="update_status" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-md transition duration-150">Save Changes</button>
                    </div>
                            </form>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($all_records)) : ?>
        <?php foreach ($all_records as $index => $record) : ?>
            <div id="modal-<?= $index ?>" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4 opacity-0 pointer-events-none">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all scale-95">
                    
                    <form action="../../controllers/update_status.php" method="POST">
                        <input type="hidden" name="request_id" value="<?= $record['id'] ?>">

                        <div class="flex justify-between items-center p-5 border-b">
                            <h3 class="text-xl font-semibold text-gray-800">Request Details</h3>
                            <button type="button" onclick="closeModal(<?= $index ?>)" class="text-gray-400 hover:text-gray-600 text-3xl font-light">&times;</button>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 max-h-[60vh] overflow-y-auto">
                           <div class="sm:col-span-2">
                                <p class="font-bold text-gray-700">Event Name</p><p class="text-gray-600"><?= htmlspecialchars($record['event_name']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Requester</p><p class="text-gray-600"><?= htmlspecialchars($record['first_name']) . ' ' . htmlspecialchars($record['last_name']) ?></p>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Organization</p><p class="text-gray-600"><?= htmlspecialchars($record['org']) ?></p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="font-bold text-gray-700">Purpose</p><p class="text-gray-600 text-justify"><?= htmlspecialchars($record['purpose']) ?></p>
                            </div>

                            
                        </div>

                        <div class="flex justify-end items-center p-4 bg-gray-50 border-t gap-x-3">
                            <button type="button" onclick="closeModal(<?= $index ?>)" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-5 rounded-md transition duration-150">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <script>
        function openModal(index) {
            const modal = document.getElementById('modal-' + index);
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.querySelector('div[role="dialog"]')?.classList.remove('scale-95'); // For transform effect
                document.body.classList.add('overflow-hidden'); // Prevent background scrolling
            }
        }

        function closeModal(index) {
            const modal = document.getElementById('modal-' + index);
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.querySelector('div[role="dialog"]')?.classList.add('scale-95'); // For transform effect
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                const openModalDiv = document.querySelector('.modal:not(.opacity-0)');
                if (openModalDiv) {
                    const modalIndex = openModalDiv.id.split('-')[1];
                    closeModal(modalIndex);
                }
            }
        };
    </script>
</body>
</html>