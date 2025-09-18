<?php
// verify_otp.php
session_start();
date_default_timezone_set('Asia/Manila');

if(isset($_POST['verify_otp'])){
$otp = implode("", $_POST['otp']);

// echo $_SESSION['otp'];


if($otp == $_SESSION['otp']){
    
    if ($_SESSION['role'] === 'admin') {
        header("Location: views/admin/index.php");
    } elseif ($_SESSION['role'] === 'gso_sec') {
        header("Location: views/gso_sec/index.php");
    } elseif ($_SESSION['role'] === 'gov_sec') {
        header("Location: views/gov_sec/index.php");
    } else {
        header("Location: views/admin/index.php");
    }
    exit();
} else {
    echo "not equal";
}
}

