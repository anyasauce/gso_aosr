<?php 
include '../config/init.php';




if(isset($_POST['add_repair'])){
    $email = $_POST['email'];
    $dep_name = $_POST['dept_name'];
    $concern = $_POST['concern'];
    $status = 'Pending';
    

    $stmt = $conn->prepare("INSERT INTO repairs (email, department_name, concern, status) VALUES(?,?,?,?)");
    $stmt->bind_param('ssss', $email, $dep_name, $concern, $status);
    
    if($stmt->execute()){
        echo json_encode(["success" => true]);
        exit;
    }
        echo json_encode(["success" => false]);
        exit;

}

?>