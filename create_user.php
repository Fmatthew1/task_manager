<?php
include 'Db.php';
include 'users.php';

$name = $email = "";
$errorMessages = ["name" => "", "email" => "", "password" => "", "general" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $status = 'active';

    //server-side validation
    if (empty($name)){
        $errorMessages['name'] = "Name is required.";
    }

    if (empty($email)) {
        $errorMessages['email'] = "Email is required.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages['email'] = "invalid email format.";
    } elseif (User::emailExists($conn, $email)) {
        $errorMessages['email'] = "Error: Email already exists.";
    }

    if (empty($password)) {
        $errorMessages['password'] = "Password is required.";
    }

        if (empty($errorMessages['name']) && empty($errorMessages['email']) && empty($errorMessages['password'])) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // var_dump($hashedPassword);
            // exit();
        // Create a new user without passing the $id
        $user = new User($conn, $name, $email, $hashedPassword, $status);

        if ($user->save()) {
            header("Location: home.php");
            exit();
        } else {
            $errorMessages['general'] = "Error creating user.";
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
                <input type="text" class="form-control" id="name" name="name" value ="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
                <?php if (!empty($errorMessages['name'])): ?>
                <div class = "text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value ="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                <?php if(!empty($errorMessages['email'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['email']; ?></div>
                    <?php endif; ?>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <?php if(!empty($errorMessages['password'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['password']; ?></div>
                    <?php endif; ?>
            </div>
            <?php if (!empty($errorMessages['general'])): ?>
                <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
