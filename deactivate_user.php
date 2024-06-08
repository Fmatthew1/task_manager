<?php
include 'Db.php';
include 'todo.php';
include 'users.php';

$id = $_GET['id'];
$user = User::find($conn, $id);

if ($user) {
    $user->setStatus('inactive');
    if ($user->save()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error deactivating user.";
    }
} else {
    echo "User not found.";
}

