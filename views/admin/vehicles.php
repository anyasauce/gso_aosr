<!-- user.php -->
<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php'; ?>
<body class="bg-gray-50">
<div class="flex">
    <?php include 'components/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
        <?php include 'components/header.php'; ?>

        <main class="p-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Vehicles Management</h2>
                    <button 
                        onclick="document.getElementById('addModal').classList.remove('hidden')" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        + Add Vehicles
                    </button>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Vehicle Name</th>
                            <th class="px-4 py-2 border">Capacity</th>
                            <th class="px-4 py-2 border">Plate No.</th>
                            <th class="px-4 py-2 border">Availability</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include '../../config/init.php'; // your DB connection

                        $result = $conn->query("SELECT * FROM vehicles");
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="px-4 py-2 border"><?= $row['id'] ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['vehicle_name']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['seat_capacity'])?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['plate_no'])?></td>

                                <td class="px-4 py-2 border flex items-center justify-center gap-3">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?=$row['vehicle_name']?>','<?= $row['seat_capacity'] ?>', <?=$row['plate_no']?>)" 
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <form action="../../controllers/VehicleController.php?id=<?= $row['id'] ?>" method="POST">
                                    <button type = "submit"  name = "delete"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add User Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Add Vehicle</h3>
        <form action="../../controllers/VehicleController.php" method="POST">
            <input type="text" name="name" placeholder="Vehicle Name" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="number" min="1" name="capacity" placeholder="Seat Capacity" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="text" name="plate_no" id="" placeholder="Plate Number" required class="w-full mb-3 border rounded px-3 py-2">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                <button type="submit" name="add_vehicle" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Edit User</h3>
        <form action="../../controllers/VehicleController.php" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="name" id="edit_email" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="number" name="capacity" id="edit_capacity" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="text" name="plate_no" id="edit_plate_no" required class="w-full mb-3 border rounded px-3 py-2">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                <button type="submit" name="update" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, email, capacity, plate_no) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_capacity').value = capacity
        document.getElementById('edit_plate_no').value = plate_no || ''

        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
</body>
</html>
