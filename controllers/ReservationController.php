<?php 
require_once '../config/init.php';

if(isset($_POST['reserve'])){
    $reservation_type = $_POST['reservationType'];
    $type_of_government = $_POST['govType'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $title = $_POST['title'];
    $organization = $_POST['org_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    echo $reservation_type;
}
?>