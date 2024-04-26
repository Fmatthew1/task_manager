<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

// $todo = new Todo($conn); // Create a new Todo instance

// $id = $_GET['id']; // Get the ID of the todo from the URL parameter

// if ($todo->complete()) {
//     header("Location: index.php");
//     exit();
// } else {
//     echo "Error completing todo";
// }
// var_dump($id);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If form is submitted, complete the todo
    $id = $_GET['id'];
   
    // Retrieve the todo object by its ID
    $todo = new Todo($conn);
   
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




