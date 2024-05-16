<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$id = $_GET['id'];

$currentTodo = Todo::find($conn, $id); // Retrieve the current todo by its ID

if (!$currentTodo) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

   
    $currentTodo->setName($name);
    // var_dump($name);
    // exit();

    if ($currentTodo->update()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating todo";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Todo</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Todo Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($currentTodo->getName(), ENT_QUOTES); ?>" required>
              
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
