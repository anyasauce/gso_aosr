<?php
require_once '../config/init.php';

if(isset($_POST['addItem'])){
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    $checkStmt = $conn->prepare("SELECT id FROM inventory WHERE item_name = ?");
    $checkStmt->bind_param("s", $item_name);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if($checkResult->num_rows > 0){
        echo json_encode(["success" => false, "message" => "Item already exists."]);
    } else {
        $stmt = $conn->prepare("INSERT INTO inventory (item_name, quantity, category, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $item_name, $quantity, $category, $status);
        $stmt->execute();
        header("Location: ../views/admin/inventory.php");

    }
};


if(isset($_POST['updateItem'])){
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE inventory SET item_name = ?, quantity = ?, category = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $item_name, $quantity, $category, $status, $id);
    $stmt->execute();

    header("Location: ../views/admin/inventory.php");
};

if(isset($_POST['deleteItem'])){
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../views/admin/inventory.php");

}