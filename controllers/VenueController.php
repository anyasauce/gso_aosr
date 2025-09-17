<?php 
require_once '../config/init.php';

if(isset($_POST['add_venue'])){
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $type = $_POST['type'];
    $location = $_POST['location'];


    $stmt = $conn->prepare("INSERT INTO venue (venue_name, capacity, type, location) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $name, $capacity, $type, $location);
    
    if($stmt->execute()){
        echo json_encode(["success" => "true"]);
    }
}

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $type = $_POST['type'];
    $location = $_POST['location'];

    $stmt = $conn -> prepare("UPDATE venue SET venue_name = ?, capacity = ?, type = ?, location = ? WHERE id = ?");
    $stmt->bind_param('sisss', $name, $capacity, $type, $location, $_POST['id']);

    if($stmt->execute()){
        echo json_encode(["success" => "true"]);
    }
}

if(isset($_POST['delete'])){
    $id=  $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM venue WHERE id = ?");
    $stmt->bind_param('i', $id);
    if($stmt->execute()){
        echo json_encode(["success" => "true"]);
    }
}
?>