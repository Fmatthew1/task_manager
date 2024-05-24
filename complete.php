<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $name = isset($_GET['name']);
 
  // If form is submitted, complete the todo
  $id = intval($_GET['id']);
 
  if ($id > 0 ) {
  $is_completed = 1; 
  $created_at = date("Y-m-d H:i:s"); 
  $updated_at = date("Y-m-d H:i:s"); 
  $completed_at = date("Y-m-d H:i:s");

  // Retrieve the todo object by its ID
  $todo = new Todo($conn, $id, $name, $is_completed, $created_at, $updated_at, $completed_at);
  // var_dump($conn, $id, $name, $is_completed, $created_at, $updated_at, $completed_at);
  // exit();
      // Check if the todo with the given ID exists
      if ($todo->findById($id)) {
         
         // Update todo details
          $todo->setName($name);
          $todo->setIsCompleted($is_completed);
          $todo->setCreatedAt($created_at);
          $todo->setUpdatedAt($updated_at);
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
  }

}




