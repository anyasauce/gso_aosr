<?php

if (session_status() == PHP_SESSION_NONE || !session_start()) {
    session_start();
}

// if(!isset($_SESSION['role'])){
//     header("Location: ../../index.php");
// }
?>
