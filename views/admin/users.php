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
                <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
                <button 
                    onclick="document.getElementById('addModal').classList.remove('hidden')" 
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                    + Add User
                </button>
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table id="usersTable" class="min-w-full border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-700 text-sm font-semibold uppercase">
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Role</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                        <?php
                        include '../../config/init.php';
                        $result = $conn->query("SELECT * FROM users");
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3"><?= $row['id'] ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($row['email']) ?></td>
                            <td class="px-6 py-3 capitalize"><?= $row['role'] ?></td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?= $row['email'] ?>', '<?= $row['role'] ?>')" 
                                        class="bg-yellow-500 text-white px-4 py-1.5 rounded-md shadow hover:bg-yellow-600 transition">
                                        Edit
                                    </button>
                                    <form action="../../controllers/UserController.php?id=<?= $row['id'] ?>" method="POST" class="inline">
                                        <button type="submit" name="delete"
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

<!-- Add User Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Add User</h3>
        <form action="../../controllers/UserController.php?action=add" method="POST" class="space-y-3">
            <input type="email" name="email" placeholder="Email" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <input type="password" name="password" placeholder="Password" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <select name="role" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="gso_sec">GSO Sec</option>
                <option value="gov_sec">Gov Sec</option>
                <option value="driver">Driver</option>
            </select>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" 
                    class="px-4 py-2 rounded border hover:bg-gray-100 transition">Cancel</button>
                <button type="submit" name="addUser" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Edit User</h3>
        <form action="../../controllers/UserController.php?action=edit" method="POST" class="space-y-3">
            <input type="hidden" name="id" id="edit_id">
            <input type="email" name="email" id="edit_email" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
            <select name="role" id="edit_role" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
                <option value="admin">Admin</option>
                <option value="gso_sec">GSO Sec</option>
                <option value="gov_sec">Gov Sec</option>
                <option value="driver">Driver</option>
            </select>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" 
                    class="px-4 py-2 rounded border hover:bg-gray-100 transition">Cancel</button>
                <button type="submit" name="updateUser" 
                    class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Update</button>
            </div>
        </form>
    </div>
</div>


<script>
    function openEditModal(id, email, role) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>
</html>
