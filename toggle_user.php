<?php
session_start();
include 'Db.php';
include 'users.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("User ID is required");
}

$user = User::find($conn, $id);

if (!$user) {
    die("User not found");
}

if ($user->toggleStatus()) {
    header("Location: manage_users.php");
    exit();
} else {
    die("Error updating user status.");
}