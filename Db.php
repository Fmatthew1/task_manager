<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "task_manager";

// create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// check connection 

if($conn->connect_error) {
    die("connection Failed: " . $conn->connect_error);
}

?>