<?php
include 'Db.php';
include 'users.php';

$name = $email = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $status = 'active';

    // Check if the email already exists
    if (User::emailExists($conn, $email)) {
        $errorMessage = "Error: Email already exists.";
    } else {
        // Create a new user without passing the $id
        $user = new User($conn, $name, $email, $status);

        if ($user->save()) {
            header("Location: home.php");
            exit();
        } else {
            $errorMessage = "Error creating user.";
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
                <input type="text" class="form-control" id="name" name="name" value ="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value ="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>"required>
                <?php if(!empty($errorMessage)): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
