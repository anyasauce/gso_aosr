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
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-700 flex items-center gap-2">
                        Vehicles Management
                    </h2>
                    <button 
                        onclick="document.getElementById('addModal').classList.remove('hidden')" 
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                        + Add Vehicle
                    </button>
                </div>

                <!-- Vehicles Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table id="vehiclesTable" class="min-w-full divide-y divide-gray-200 text-center">
                        <thead class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Vehicle Name</th>
                            <th class="px-4 py-3">Capacity</th>
                            <th class="px-4 py-3">Plate No.</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr> 
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        <?php
                        include '../../config/init.php'; // DB connection

                        $result = $conn->query("SELECT * FROM vehicles");
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3"><?= $row['id'] ?></td>
                                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['vehicle_name']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['seat_capacity'])?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['plate_no'])?></td>

                                <td class="px-4 py-3 flex justify-center gap-3">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?=$row['vehicle_name']?>','<?= $row['seat_capacity'] ?>', '<?= $row['plate_no']?>')" 
                                        class="bg-yellow-500 text-white px-4 py-1.5 rounded-lg hover:bg-yellow-600 shadow-sm transition">
                                        Edit
                                    </button>
                                    <form action="../../controllers/VehicleController.php?id=<?= $row['id'] ?>" method="POST">
                                        <button type="submit" name="delete"
                                            class="bg-red-600 text-white px-4 py-1.5 rounded-lg hover:bg-red-700 shadow-sm transition">
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

<!-- Add Vehicle Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
        <Add class="text-lg font-semibold mb-4 text-gray-700">Add Vehicle</h3>
        <form action="../../controllers/VehicleController.php" method="POST" class="space-y-3">
            <input type="text" name="name" placeholder="Vehicle Name" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
            <input type="number" min="1" name="capacity" placeholder="Seat Capacity" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
            <input type="text" name="plate_no" placeholder="Plate Number" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" name="add_vehicle" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Vehicle Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Edit Vehicle</h3>
        <form action="../../controllers/VehicleController.php" method="POST" class="space-y-3">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="name" id="edit_email" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">
            <input type="number" name="capacity" id="edit_capacity" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">
            <input type="text" name="plate_no" id="edit_plate_no" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" name="update" 
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 shadow">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, capacity, plate_no) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_email').value = name;
        document.getElementById('edit_capacity').value = capacity;
        document.getElementById('edit_plate_no').value = plate_no || '';

        document.getElementById('editModal').classList.remove('hidden');
    }
</script>

<script>
    $(document).ready(function() {
        $('#vehiclesTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>
</html>
