<?php 
require_once '../config/init.php';

if(isset($_POST['add_vehicle'])){
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $plate_no = $_POST['plate_no'];


    $stmt = $conn->prepare("INSERT INTO vehicles (vehicle_name, seat_capacity, plate_no) VALUES (?,?,?)");
    $stmt->bind_param("sis", $name, $capacity, $plate_no);
    
    if($stmt->execute()){
        echo json_encode(["success" => "true"]);
    }
}

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $plate_no = $_POST['plate_no'];

    $stmt = $conn -> prepare("UPDATE vehicles SET vehicle_name = ?, seat_capacity = ?, plate_no = ? WHERE id = ?");
    $stmt->bind_param('sisi', $name, $capacity, $plate_no, $_POST['id']);

    if($stmt->execute()){
        echo json_encode(["success" => "true"]);
    }
}

if(isset($_POST['delete'])){
    $id=  $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM vehicles WHERE id = ?");
    $stmt->bind_param('i', $id);
    if($stmt->execute()){
        echo json_encode(["success" => "true"]);
    }
}
?>