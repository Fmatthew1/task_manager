<?php
include 'Db.php';
include 'users.php';
include 'roles.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_role'])) {
        $role = new Role($conn, $_POST['name']);
        $role->create();
    } elseif (isset($_POST['update_role'])) {
        $role = Role::find($conn, $_POST['id']);
        $role->setName($_POST['name']);
        $role->update();
    } elseif (isset($_POST['delete_role'])) {
        $role = Role::find($conn, $_POST['id']);
        $role->delete();
    }
}

$roles = Role::findAll($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Roles</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="manage_users.php"><button class="btn btn-primary" type="button">ManageUsers</button></a>
        </div>
        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="create_role">Create Role</button>
        </form>

        <h2>Existing Roles</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role): ?>
                <tr>
                    <td><?php echo $role->getId(); ?></td>
                    <td><?php echo htmlspecialchars($role->getName()); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $role->getId(); ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($role->getName()); ?>" required>
                            <button type="submit" class="btn btn-warning btn-sm" name="update_role">Update</button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $role->getId(); ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="delete_role">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


