<?php
include 'Db.php';
include 'users.php';

$users = User::findAll($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Users</h1>
        <a href="create_user.php" class="btn btn-primary mb-3">Create User</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user->getName()); ?></td>
                        <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($user->getStatus()); ?></td>
                        <td>
                            <a href="update_user.php?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-info">Update</a>
                            <?php if ($user->getStatus() == 'active') { ?>
                                <a href="deactivate_user.php?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-warning">Deactivate</a>
                            <?php } else { ?>
                                <a href="activate_user.php?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-success">Activate</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
