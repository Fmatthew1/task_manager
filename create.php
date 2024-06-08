<?php
include 'Db.php';
include 'todo.php';
include 'users.php';

// Retrieve all users
$users = User::findAll($conn);

// Filter active users
$activeUsers = array_filter($users, function($user) {
    return $user->getStatus() === 'active';
});

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $user_id = intval($_POST["user_id"]);
    $is_completed = 0;
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;

    // Create a new Todo object
    $todo = new Todo($conn, $name, $is_completed, $created_at, $updated_at, $id, $completed_at, $user_id);

    // Save the new todo
    if ($todo->create()) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Todo</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back</a>
        <form action="create.php" method="POST">
            <div class="form-group mb-3">
                <label for="name">Todo Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="user_id">Assign to User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php foreach ($activeUsers as $user) { ?>
                        <option value="<?php echo $user->getId(); ?>"><?php echo htmlspecialchars($user->getName()); ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
