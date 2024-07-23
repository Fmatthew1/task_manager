<?php
session_start();
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class
include 'users.php';

$id = $_GET['id'];

$currentTodo = Todo::findById($conn, $_GET['id']);

if (!$currentTodo) {
    header("Location: index.php");
    exit();
}

$activeUsers = User::findAllActive($conn);

$name = "";
$errorMessages = ["name" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $is_completed = isset($_POST['is_completed']) ? 1 : 0;
    $currentTodo->setName($name);
    $currentTodo->setIsCompleted($is_completed);
    $currentTodo->setUserId($user_id);
    $currentTodo->setUpdatedAt(date('Y-m-d H:i:s'));

    //server-side validation
    if (empty($name)) {
        $errorMessages['name'] = "Name is required.";
    }

    if (empty($errorMessages['name'])) {
    
   
    if ($currentTodo->update()) {
        header("Location: index.php");
        exit();
    } else {
        $errorMessages['general'] = "Error updating todo";
    }
    
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
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="index.php"><button class="btn btn-primary" type="button">Back</button></a>
        </div>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Todo Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($currentTodo->getName(), ENT_QUOTES); ?>">
                <?php if (!empty($errorMessages['name'])): ?>
                    <div class="text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-3">
                <label for="user_id">Assign to User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php foreach ($activeUsers as $user):  ?>
                        <option value="<?php echo $user->getId(); ?>" <?php echo $user->getId() == $currentTodo->getUserId() ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($user->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if (!empty($errorMessages['general'])): ?>
                <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
