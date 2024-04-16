<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$todo = new Todo($conn); // Create a new Todo instance

$id = $_GET['id']; // Get the ID of the todo from the URL parameter

if ($todo->complete($id)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error completing todo";
}

?>

