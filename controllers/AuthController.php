<?php 
require_once '../config/init.php';
<<<<<<< HEAD
=======
// session_start();
>>>>>>> 6cccc5793ebe334ac2b99af1e3a911c6e2bedc96

if (isset($_POST['login'])) {
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

            $lastLogin    = $user['last_login'];
            // $lastLoginTime = new DateTime($lastLogin ?? '');
            $currentTime   = new DateTime("now");
            
            if (!empty($lastLogin)) {
            $lastLoginTime = new DateTime($lastLogin);
            } else {
                $lastLoginTime = new DateTime(); // default to now
            }

            $diffInSeconds = $currentTime->getTimestamp() - $lastLoginTime->getTimestamp();
            $diffInHours   = floor($diffInSeconds / 3600);

            if ($diffInHours > 3 || is_null($user['last_login']) || empty($user['last_login'])) {
                // Generate and store OTP
                $otp = random_int(1000, 9999);
                $_SESSION['otp'] = $otp;

                require_once 'PHPMailerController.php';
                sendOTP($email, $otp);

                // Redirect to OTP page
                header("Location: ../otp.php");
                exit();
            }  else {
                // Redirect based on role
                switch ($user['role']) {
                    case 'admin':
                        header("Location: ../views/admin/index.php");
                        break;
                    case 'gso_sec':
                        header("Location: ../views/gso_sec/index.php");
                        break;
                    case 'gov_sec':
                        header("Location: ../views/gov_sec/index.php");
                        break;
                    default:
                        header("Location: ../views/admin/index.php");
                }
                exit();
            }

        } else {
            echo "<script>
                    alert('Incorrect password.');
                    window.location.href = '../views/auth/login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not Found!');
                window.location.href = '../views/auth/login.php';
              </script>";
    }
}
?>
