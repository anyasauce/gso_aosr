<?php
include 'config/init.php'; // contains $conn (mysqli connection)

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (!empty($email) && !empty($password) && !empty($role)) {
        // Hash the password before inserting
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            $message = "✅ New admin inserted successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Insert Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Add New Admin</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 p-3 text-white rounded-lg 
                  <?= str_starts_with($message, '✅') ? 'bg-green-500' : 'bg-red-500' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" required
               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Role</label>
        <select name="role" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option value="">-- Select Role --</option>
          <option value="admin">Admin</option>
          <option value="gso_sec">GSO Secretary</option>
          <option value="gov_sec">Government Secretary</option>
          <option value="driver">Driver</option>
        </select>
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
        Insert Admin
      </button>
    </form>
  </div>

</body>
</html>
