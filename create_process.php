<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class
$name = $_POST['name']; // Get the name of the todo from the form
$todo = new Todo($conn, $name, $is_completed, $created_at, $updated_at);

if ($todo->create()) {
    header("Location: index.php"); // Redirect to the index page after successful creation
} else {
    echo "Error creating todo";
}

