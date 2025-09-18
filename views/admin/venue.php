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
                        Venue Management
                    </h2>
                    <button 
                        onclick="document.getElementById('addModal').classList.remove('hidden')" 
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                        + Add Venue
                    </button>
                </div>

                <!-- Venues Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 text-center">
                        <thead class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3">Venue Name</th>
                            <th class="px-4 py-3">Capacity</th>
                            <th class="px-4 py-3">Location</th>
                            <th class="px-4 py-3">Availability</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        <?php
                        include '../../config/init.php'; // DB connection

                        $result = $conn->query("SELECT * FROM venue");
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['venue_name']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['capacity']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['location'])?></td>
                                <td class="px-4 py-3">
                                    <?php if($row['availability'] == "available"): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Available</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Unavailable</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 flex justify-center gap-3">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?=$row['venue_name']?>','<?= $row['capacity'] ?>','<?=$row['location']?>', '<?=$row['type']?>')" 
                                        class="bg-yellow-500 text-white px-4 py-1.5 rounded-lg hover:bg-yellow-600 shadow-sm transition">
                                        Edit
                                    </button>
                                    <form action="../../controllers/VenueController.php?id=<?= $row['id'] ?>" method="POST">
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

<!-- Add Venue Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Add Venue</h3>
        <form action="../../controllers/VenueController.php" method="POST" class="space-y-3">
            <input type="text" name="name" placeholder="Venue Name" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
            <input type="text" name="location" placeholder="Location" 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
            <select name="type" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
                <option value="" selected disabled>Type</option>
                <option value="Theatre Style">Theatre Style</option>
                <option value="Classroom Style">Classroom Style</option>
                <option value="Banquet Style">Banquet Style</option>
                <option value="Cabaret Style">Cabaret Style</option>
                <option value="Boardroom Style">Boardroom Style</option>
                <option value="Hollow Square">Hollow Square</option>
                <option value="Cocktail / Standing Reception">Cocktail / Standing Reception</option>
            </select>
            <input type="number" min="1" name="capacity" placeholder="Capacity" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-200">
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" name="add_venue" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Venue Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Edit Venue</h3>
        <form action="../../controllers/VenueController.php" method="POST" class="space-y-3">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="name" id="edit_name" placeholder="Venue Name" required 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">
            <input type="text" name="location" id="edit_location" placeholder="Location" 
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">
            <select name="type" id="edit_type" 
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">
                <option value="" selected disabled>Type</option>
                <option value="Theatre Style">Theatre Style</option>
                <option value="Classroom Style">Classroom Style</option>
                <option value="Banquet Style">Banquet Style</option>
                <option value="Cabaret Style">Cabaret Style</option>
                <option value="Boardroom Style">Boardroom Style</option>
                <option value="Hollow Square">Hollow Square</option>
                <option value="Cocktail / Standing Reception">Cocktail / Standing Reception</option>
            </select>
            <input type="number" min="1" id="edit_capacity" name="capacity" placeholder="Capacity" required 
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
