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
                    <h2 class="text-xl font-semibold">User Management</h2>
                    <button 
                        onclick="document.getElementById('addModal').classList.remove('hidden')" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        + Add User
                    </button>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Role</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include '../../config/init.php'; // your DB connection

                        $result = $conn->query("SELECT * FROM users");
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="px-4 py-2 border"><?= $row['id'] ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="px-4 py-2 border capitalize"><?= $row['role'] ?></td>
                                <td class="px-4 py-2 border flex items-center justify-center gap-3">
                                    <button 
                                        onclick="openEditModal(<?= $row['id'] ?>, '<?= $row['email'] ?>', '<?= $row['role'] ?>')" 
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <a href="../../controllers/UserController.php?action=delete&id=<?= $row['id'] ?>" 
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                        onclick="return confirm('Delete this user?')">
                                        Delete
                                    </a>
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
        <h3 class="text-lg font-semibold mb-4">Add User</h3>
        <form action="../../controllers/UserController.php?action=add" method="POST">
            <input type="email" name="email" placeholder="Email" required class="w-full mb-3 border rounded px-3 py-2">
            <input type="password" name="password" placeholder="Password" required class="w-full mb-3 border rounded px-3 py-2">
            <select name="role" required class="w-full mb-3 border rounded px-3 py-2">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="gso_sec">GSO Sec</option>
                <option value="gov_sec">Gov Sec</option>
                <option value="driver">Driver</option>
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                <button type="submit" name="addUser" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Edit User</h3>
        <form action="../../controllers/UserController.php?action=edit" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="email" name="email" id="edit_email" required class="w-full mb-3 border rounded px-3 py-2">
            <select name="role" id="edit_role" required class="w-full mb-3 border rounded px-3 py-2">
                <option value="admin">Admin</option>
                <option value="gso_sec">GSO Sec</option>
                <option value="gov_sec">Gov Sec</option>
                <option value="driver">Driver</option>
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                <button type="submit" name="updateUser" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
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
</body>
</html>
