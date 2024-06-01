<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If the form is submitted, complete the todo
    $id = intval($_GET['id']);

    if ($id > 0) {
        $is_completed = 1; 
       // $updated_at = date("Y-m-d H:i:s"); 
        $completed_at = date("Y-m-d H:i:s");

        // Check if the todo with the given ID exists using the static method
        $todo = Todo::findById($conn, $id);

        if ($todo) {
            error_log("Todo found: " . print_r($todo, true));
        } else {
            error_log("Todo not found with ID: $id");
        }
        
        if ($todo) {
            $todo->setIsCompleted($is_completed);
            //$todo->setUpdatedAt($updated_at);
            $todo->setCompletedAt($completed_at);
          
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
    } else {
        echo "Invalid ID";
    }
}
