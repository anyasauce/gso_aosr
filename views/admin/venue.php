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
                    <h2 class="text-xl font-semibold">Venue Management</h2>
                    <button 
                        onclick="document.getElementById('addModal').classList.remove('hidden')" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        + Add Venue
                    </button>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Venue Name</th>
                            <th class="px-4 py-2 border">Capacity</th>
                            <th class="px-4 py-2 border">Location</th>
                            <th class="px-4 py-2 border">Availability</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include '../../config/init.php'; // your DB connection

                        $result = $conn->query("SELECT * FROM venue");
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['venue_name']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['capacity']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['location'])?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['availability'])?></td>

                                <td class="px-4 py-2 border flex items-center justify-center gap-3">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?=$row['venue_name']?>','<?= $row['capacity'] ?>','<?=$row['location']?>', '<?=$row['type']?>')" 
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <form action="../../controllers/VenueController.php?id=<?= $row['id'] ?>" method="POST">
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
        <h3 class="text-lg font-semibold mb-4">Add Venue</h3>
        <form action="../../controllers/VenueController.php" method="POST">
            <input type="text" name="name" placeholder="Venue Name" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="text" name="location" id="" placeholder="Location" class="w-full mb-3 border rounded px-3 py-2">
            <select name="type" id="" class = "w-full mb-3 border rounded px-3 py-2">
                <option value="" selected disabled>Type</option>
                <option value="Theatre Style">Theatre Style</option>
                <option value="Classroom Style">Classroom Style</option>
                <option value="Banquet Style">Banquet Style</option>
                <option value="Cabaret Style">Cabaret Style</option>
                <option value="Boardroom Style">Boardroom Style</option>
                <option value="Hollow Square">Hollow Square</option>
                <option value="Coacktail / Standing Reception">Coacktail / Standing Reception</option>
                <option value="Boardroom Style">Boardroom Style</option>
            </select>
            <input type="number" min="1" name="capacity" placeholder="Capacity" required class="w-full mb-3 border rounded px-3 py-2">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                <button type="submit" name="add_venue" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Add Venue</h3>
        <form action="../../controllers/VenueController.php" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="name" placeholder="Venue Name" id = "edit_name" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="text" name="location" id="edit_location" placeholder="Location" class="w-full mb-3 border rounded px-3 py-2">
            <select name="type" id="edit_type" class = "w-full mb-3 border rounded px-3 py-2">
                <option value="" selected disabled>Type</option>
                <option value="Theatre Style">Theatre Style</option>
                <option value="Classroom Style">Classroom Style</option>
                <option value="Banquet Style">Banquet Style</option>
                <option value="Cabaret Style">Cabaret Style</option>
                <option value="Boardroom Style">Boardroom Style</option>
                <option value="Hollow Square">Hollow Square</option>
                <option value="Coacktail / Standing Reception">Coacktail / Standing Reception</option>
                <option value="Boardroom Style">Boardroom Style</option>
            </select>
            <input type="number" min="1" id = "edit_capacity" name="capacity" placeholder="Capacity" required class="w-full mb-3 border rounded px-3 py-2">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                <button type="submit" name="update" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>s
</div>

<script>
    function openEditModal(id, name, capacity, location, type) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_capacity').value = capacity;
        document.getElementById('edit_location').value = location;
        document.getElementById('edit_type').value = type;


        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
</body>
</html>
