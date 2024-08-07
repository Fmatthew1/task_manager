<?php
session_start();
include 'Db.php';   // Assuming Db.php contains database connection logic
include 'todo.php'; // Assuming todo.php contains Todo class definition
include 'users.php'; // Assuming users.php contains User class definition

// Retrieve all users
$users = User::findAll($conn); // Assuming $conn is your database connection object

// Filter active users
$activeUsers = array_filter($users, function($user) {
    return $user->getStatus() === 'active';
});

$name = "";
$errorMessages = ["name" => ""];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $user_id = intval($_POST["user_id"]);
    $is_completed = 0; // Assuming this is the default value for new todos
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;
    $completed_at = null; // Assuming this is initially null for new todos

    //server-side validation
    if (empty($name)){
        $errorMessages['name'] = "Name is required.";
    }

    if (empty($errorMessages['name'])) {
    // Create a new Todo object
    $todo = new Todo($conn, $name, $is_completed, $created_at, $updated_at, $id = null, $completed_at, $user_id); // Passing null for $id as it's usually auto-incremented

    // Save the new todo
    $result = $todo->create();
    if ($result === true) {
        header("Location: index.php");
        exit();
    } else {
        $errorMessages['general'] = "Error creating todo: " . $result; // Output the specific error message
    }

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
                <input type="text" class="form-control" id="name" name="name">
                <?php if (!empty($errorMessages['name'])): ?>
                <div class = "text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-3">
                <label for="user_id">Assign to User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php foreach ($activeUsers as $user) { ?>
                        <option value="<?php echo $user->getId(); ?>"><?php echo htmlspecialchars($user->getName()); ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php if (!empty($errorMessages['general'])): ?>
                <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
