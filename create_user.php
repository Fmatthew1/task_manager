<?php
include 'Db.php';
include 'users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $status = 'active';

    // Check if the email already exists
    if (User::emailExists($conn, $email)) {
        echo "Error: Email already exists.";
    } else {
        // Create a new user without passing the $id
        $user = new User($conn, $name, $email, $status);

        if ($user->save()) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error creating user.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create User</h1>
        <a href="home.php" class="btn btn-primary mb-3">Back</a>
        <form action="create_user.php" method="POST">
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
