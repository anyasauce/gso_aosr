<?php
require_once '../config/init.php';

// CREATE - Add User
if (isset($_POST['addUser'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $role);

    if ($stmt->execute()) {
        ?>
        <script>
            alert("User added successfully!");
            window.location.href = "../views/admin/users.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Failed to add user.");
            window.location.href = "../views/admin/users.php";
        </script>
        <?php
    }
}

// UPDATE - Edit User
if (isset($_POST['updateUser'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET email=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $email, $password, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET email=?, role=? WHERE id=?");
        $stmt->bind_param("ssi", $email, $role, $id);
    }

    if ($stmt->execute()) {
        ?>
        <script>
            alert("User updated successfully!");
            window.location.href = "../views/admin/users.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Failed to update user.");
            window.location.href = "../views/admin/users.php";
        </script>
        <?php
    }
}

// DELETE - Remove User
if (isset($_POST['delete'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        ?>
        <script>
            alert("User deleted successfully!");
            window.location.href = "../views/admin/users.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Failed to delete user.");
            window.location.href = "../views/admin/users.php";
        </script>
        <?php
    }
}
?>
