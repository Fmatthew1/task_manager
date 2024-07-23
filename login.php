<?php
session_start();
require 'Db.php'; // Make sure to include your database connection
require 'users.php'; // Include the User class
require 'roles.php';

$email = "";
$errorMessages = ["email" => "", "password" => "", "general" => ""];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //server-side validation
        if (empty($email)) {
            $errorMessages['email'] = "Email is required.";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages['email'] = "invalid email format.";
        } 

        if (empty($password)) {
            $errorMessages['password'] = "Password is required.";
        }
    
        if (empty($errorMessages['email']) && empty($errorMessages['password'])) {

        // Query to get the user by email
        //    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        //     if ($stmt === false) {
        //         die('Prepare failed: ' . htmlspecialchars($conn->error));
        //     }
        //     $stmt->bind_param("s", $email);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     $user = $result->fetch_assoc(); 
                $sql = "SELECT id, password, role_id FROM users WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            
            header("Location: home.php");
            exit;
        } else {
            $errorMessages['general'] =  "Invalid email or password";
           
        }

        $stmt->close();
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Login</h1>
        <?php if (!empty($errorMessages['general'])): ?>
            <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
        <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <div class="form-group mb-3">
        <input type="email" name="email" value ="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
        <?php if(!empty($errorMessages['email'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['email']; ?></div>
                    <?php endif; ?>
        </div>
        <label for="password">Password:</label>
        <div class="form-group mb-3">
        <input type="password" name="password">
        <?php if(!empty($errorMessages['password'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['password']; ?></div>
                    <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success">Login</button>
    </form>
    </div>
</body>
</html>
    
