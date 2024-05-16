<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'name' key exists in $_POST array
    if(isset($_POST['name'])){
        
        $name = $_POST['name'];
         // var_dump($name);
    } else {
        $name = null; // Set $name to null if not provided
    }

    // Check if 'id' key exists in $_POST array
    if(isset($_POST['id'])){
      
        $id = $_POST['id'];
        
    } else {
        $id = null; // Set $id to null if not provided
    }
    
    $is_completed = false; 
    
    $created_at = date("Y-m-d H:i:s");
    
    $updated_at = date("Y-m-d H:i:s"); 
    // var_dump($created_at);
    // exit();
    

    // Establish a connection to your MySQL database
    $mysqli = new mysqli("localhost", "root", "", "task_manager");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare and execute the SQL query to insert data into the database
    $query = "INSERT INTO todos (id, name, is_completed, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("isiss", $id, $name, $is_completed, $created_at, $updated_at);
   


    // Execute the query
    $result = $stmt->execute();
    if ($result === false) {
        die("Error: " . $stmt->error); // Print any error from executing the query
    }

    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();
   

    echo "Todo created successfully!";
     
} else {
    echo "Invalid request method.";
}

