<?php 
require_once '../config/init.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['role']    = $user['role'];
            header("Location: ../views/admin/index.php");
            exit();
        } else {
            ?>
            <script>
                alert("Incorrect password.");
                window.location.href = "../views/auth/login.php";
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("User not Found!");
            window.location.href = "../views/auth/login.php";
        </script>
        <?php
    }
}



?>