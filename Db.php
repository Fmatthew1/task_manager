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

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function checkRole($requiredRole) {
    global $conn;
    $userId = $_SESSION['user_id'];
    $sql = "SELECT roles.name FROM users JOIN roles ON users.role_id = roles.id WHERE users.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userRole = $result->fetch_assoc()['name'];

    if ($userRole != $requiredRole) {
        header("Location: unauthorized.php");
        exit();
    }
}

