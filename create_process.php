<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']) ?? null;
    $id = $_POST['id'] ?? null;
    // var_dump($id);
    // exit();
       
    if (!empty($name)) {
        $is_completed = 0; 
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $completed_at = null;
        // var_dump($created_at, $updated_at, $name);
        // exit();
        $todo = new Todo($conn, $name, $is_completed, $created_at, $updated_at, $id, $completed_at);
        
        
        if ($todo->create()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error creating todo.";
        }
    } else {
        echo "Name is required to create a todo.";
    }
} else {
    echo "Invalid request method.";
}