<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$todo = new Todo($conn); // Create a new Todo instance

$name = $_POST['name']; // Get the name of the todo from the form

if ($todo->create($name)) {
    header("Location: index.php"); // Redirect to the index page after successful creation
} else {
    echo "Error creating todo";
}

