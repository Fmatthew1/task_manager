<?php
include 'Db.php';
include 'todo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]); 
  
   $id = $_POST['id'] ?? null;
    $is_completed = 0;
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;
    $completed_at = date("Y-m-d H:i:s");
    
     // Create a new Todo object
    $todo = new Todo($conn, $name, $is_completed, $created_at, $updated_at, $id, $completed_at);
   
    if ($todo->create()) { // Assuming create() method handles database insertion
        
        header("Location: index.php");
        exit();
    } else {
        echo "Error creating todo.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Todo</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="index.php"><button class="btn btn-primary" type="button">Back</button></a>
        </div>
        <form action="create_process.php" method="POST">
            <div class="form-group">
                <label for="name">Todo Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
