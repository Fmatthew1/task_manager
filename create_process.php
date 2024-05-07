<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$name = $_POST['name'];
$is_completed = false; 
$created_at = date('Y-m-d H:i:s'); 
$updated_at = date('Y-m-d H:i:s'); 

// Create a new Todo object
$todo = new Todo($conn, $name, $is_completed, $created_at, $updated_at);

// Check if $todo is created successfully
if ($todo->create()) {
    echo "Todo created successfully!";
} else {
    echo "Error creating todo.";
}
