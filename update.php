<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$todo = new Todo($conn); // Create a new Todo instance

$id = $_GET['id']; // Get the ID of the todo from the URL parameter
$currentTodo = $todo->find($id); // Get the current todo

if (!$currentTodo) {
    // If todo not found, redirect to index page
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If form is submitted, update the todo
    $name = $_POST['name'];
    if ($todo->update($id, $name)) {
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
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $currentTodo->name; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
