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

    // validate first

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $validate_email = $stmt->get_result();

    if($validate_email->num_rows == 0){
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM requests WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        exit;
    }


    $stmt = $conn->prepare("INSERT INTO requests (res_type, type_gov, email, first_name, last_name, title, org, phone, address) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssss', $reservation_type, $type_of_government, $email, $first_name, $last_name, $title, $organization, $phone_number, $address);
    $stmt->execute();

    $req_id = $conn->insert_id;
   if($reservation_type === 'place'){
       $event_name = $_POST['event_name'];
       $res_place = $_POST['event_name'];
       $num_person = $_POST['num_person'];
       $num_chairs = $_POST['num_chairs'];
       $sound_system = $_POST['sound_system'];
       $start_date = $_POST['start_date'];
       $start_time = $_POST['start_time'];
       $end_date = $_POST['end_date'];
       $end_time = $_POST['end_time'];
       $purpose = $_POST['purpose'];
       $additional_notes = $_POST['additional_notes'];

        $stmt = $conn->prepare("UPDATE requests SET event_name = ?, res_place = ?, num_person = ?, num_chairs = ?, sound_system = ?, start_date = ?, start_time = ?, end_date = ?, end_time = ?, purpose =?, add_notes = ? WHERE id = ?");
        $stmt->bind_param('ssiisssssssi', $event_name, $res_place, $num_person, $num_chairs, $sound_system, $start_date, $start_time, $end_date, $end_time, $purpose, $additional_notes, $req_id);


        if($stmt->execute()){
            echo json_encode(["success" => "true" ]);
            exit;
        }

   }

   echo "Arwin";
}
?>