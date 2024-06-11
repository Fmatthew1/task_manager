<?php
include 'Db.php';
include 'users.php';

$id = $_GET['id'];
$user = User::find($conn, $id);

if ($user) {
    if ($user->activate()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error activating user.";
    }
} else {
    echo "User not found.";
}

