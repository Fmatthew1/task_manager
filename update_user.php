<?php
include 'Db.php';
include 'users.php';

$id = $_GET['id'];
$currentUser = User::find($conn, $id);

if (!$currentUser) {
    header("Location: home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    $currentUser->setName($name);
    $currentUser->setEmail($email);

    if ($currentUser->save()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error updating user.";
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
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($currentUser->getName(), ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($currentUser->getEmail(), ENT_QUOTES); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
