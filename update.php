<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$id = $_GET['id']; // Get the ID of the todo from the URL parameter
$currentTodo = Todo::find($conn, $id); // Get the current todo
//var_dump($currentTodo);
if (!$currentTodo) {
    // If todo not found, redirect to index page
    header("Location: index.php");
    exit();
}

if ($currentTodo->getIsCompleted()) {
    // if todo is completed redirect to index page or display a message
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If form is submitted, update the todo

    $name = $_POST['name'];
    $id = $_POST['id'];

    $currentTodo->setName($name);
    
    // Call the update method on the todo object
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
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $currentTodo->name; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
