<?php include '../../config/init.php'; ?>
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
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Inventory Management</h2>
                <button 
                    onclick="document.getElementById('addModal').classList.remove('hidden')" 
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                    + Add Item
                </button>
            </div>

            <!-- Inventory Table -->
            <div class="overflow-x-auto">
                <table id="inventoryTable" class="min-w-full border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-700 text-sm font-semibold uppercase">
                            <th class="px-6 py-3 text-left">Item Name</th>
                            <th class="px-6 py-3 text-left">Quantity</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                        <?php
                        $result = $conn->query("SELECT * FROM inventory");
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr class="hover:bg-gray-50"> 
                            <td class="px-6 py-3"><?= htmlspecialchars($row['item_name']) ?></td>
                            <td class="px-6 py-3"><?= $row['quantity'] ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($row['category']) ?></td>
                            <td class="px-6 py-3 capitalize"><?= $row['status'] ?></td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?= $row['item_name'] ?>', <?= $row['quantity'] ?>, '<?= $row['category'] ?>', '<?= $row['status'] ?>')" 
                                        class="bg-yellow-500 text-white px-4 py-1.5 rounded-md shadow hover:bg-yellow-600 transition">
                                        Edit
                                    </button>
                                    <form action="../../controllers/InventoryController.php?id=<?= $row['id'] ?>" method="POST" class="inline">
                                        <button type="submit" name="deleteItem"
                                            class="bg-red-600 text-white px-4 py-1.5 rounded-md shadow hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
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

<!-- Add Item Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Add Inventory Item</h3>
        <form action="../../controllers/InventoryController.php" method="POST" class="space-y-3">
            <input type="text" name="item_name" placeholder="Item Name" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <input type="number" name="quantity" placeholder="Quantity" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <select name="category" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <option value="--">Choose a category..</option>
                <option value="furniture">Furniture</option>
                <option value="electronics">Electronics</option>
                <option value="office-supplies">Office Supplies</option>
                <option value="others">Others</option>
            </select>
            <select name="status" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" 
                    class="px-4 py-2 rounded border hover:bg-gray-100 transition">Cancel</button>
                <button type="submit" name="addItem" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Item Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Edit Inventory Item</h3>
        <form action="../../controllers/InventoryController.php" method="POST" class="space-y-3">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="item_name" id="edit_item_name" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
            <input type="number" name="quantity" id="edit_quantity" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
            <input type="text" name="category" id="edit_category" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
            <select name="status" id="edit_status" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" 
                    class="px-4 py-2 rounded border hover:bg-gray-100 transition">Cancel</button>
                <button type="submit" name="updateItem" 
                    class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Update</button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function openEditModal(id, item_name, quantity, category, status) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_item_name').value = item_name;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_status').value = status;
        document.getElementById('editModal').classList.remove('hidden');
    }


</script>

<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>
</html>
