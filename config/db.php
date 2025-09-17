<?php

$localhost = "mysql-clams1.alwaysdata.net";
$username = "clams1";
$password = "Clams@2025";
$database = "clams1_gso_aosr_database";

$conn = new mysqli($localhost, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>