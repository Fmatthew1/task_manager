<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['name']) && isset($_GET['id'])) {
    // If form is submitted, complete the todo
    $name = $_GET['name'];
    $id = $_GET['id'];
    $is_completed = 0; 
    $created_at = date("Y-m-d H:i:s"); 
    $updated_at = date("Y-m-d H:i:s"); 
   
    // Retrieve the todo object by its ID
    $todo = new Todo($id, $name, $is_completed, $created_at, $updated_at, $id);

        if ($todo->findById($id)) {
       
        // Call the complete method on the todo object
        if ($todo->complete()) {

            header("Location: index.php");
            
            exit();
            
        } else {
            echo "Error completing todo";
        }
    } else {
        echo "Todo not found";
    }
}




