<?php
include 'Db.php';
include 'users.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    die("User ID is required");
}

$user = User::find($conn, $id);

if (!$user) {
    die("User not found");
}

if ($user->delete()) {
    header("Location: manage_users.php");
    exit();
} else {
    die("Error deleting user.");
}