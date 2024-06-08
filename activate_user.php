<?php
include 'Db.php';
include 'todo.php';
include 'users.php';

$id = $_GET['id'];
$user = User::find($conn, $id);

if ($user) {
    $user->setStatus('active');
    if ($user->save()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error activating user.";
    }
} else {
    echo "User not found.";
}

