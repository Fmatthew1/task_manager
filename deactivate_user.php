<?php
include 'Db.php';
include 'users.php';

$id = $_GET['id'];
$user = User::find($conn, $id);

if ($user) {
    if ($user->deactivate()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error deactivating user.";
    }
} else {
    echo "User not found.";
}

