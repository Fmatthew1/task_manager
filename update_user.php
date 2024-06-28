<?php
include 'Db.php';
include 'users.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("User ID is required");
}

$user = User::find($conn, $id);

if (!$user) {
    die("User not found");
}


$name = $email = "";
$errorMessages = ["name" => "", "email" => ""];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    //server-side validation
    if (empty($name)) {
        $errorMessages['name'] = "Name is required.";
    }

    if (empty($email)) {
        $errorMessages['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages['email'] = "invalid email format.";
    } else {
        $existingUser = User::findByEmail($conn, $email);
        if ($existingUser && $existingUser->getId() !== $user->getId()) {
            $errorMessages['email'] = "Error: Email already exists.";
        }
      
    }

    if (empty($errorMessages['name']) && empty($errorMessages['email'])) {
        $user->setName($name);
        $user->setEmail($email);


    if ($user->save()) {
        header("Location: home.php");
        exit();
    } else {
        $errorMessages['general'] = "Error updating user.";
    }
    
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Update User</h1>
        <a href="home.php" class="btn btn-primary mb-3">Back</a>
        <form action="update_user.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user->getName(), ENT_QUOTES); ?>">
                <?php if (!empty($errorMessages['name'])): ?>
                    <div class="text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail(), ENT_QUOTES); ?>">
                <?php if (!empty($errorMessages['email'])): ?>
                    <div class="text-danger mt-2"><?php echo $errorMessages['email']; ?></div>
                <?php endif; ?>
            </div>
            <?php if (!empty($errorMessages['general'])): ?>
                <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
