<?php
include 'Db.php';
include 'users.php';
include 'roles.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_user'])) {
        $user = new User($conn, $_POST['name'], $_POST['email'], $_POST['status'], $_POST['role_id'], $_POST['id']);
        $user->create();
    } elseif (isset($_POST['update_user']) && isset($_POST['id'])) {
        $user = User::find($conn, $_POST['id']);
        if ($user) {
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setStatus($_POST['status']);
            $user->setRoleId($_POST['role_id']);
            $user->update();
        }
    } elseif (isset($_POST['delete_user']) && isset($_POST['id'])) {
        $user = User::find($conn, $_POST['id']);
        if ($user) {
            $user->delete();
        }
    }
}

$users = User::findAll($conn);
$roles = Role::findAll($conn);
$rolesArray = [];
foreach ($roles as $role) {
    $rolesArray[$role->getId()] = $role->getName();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Users</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="manage_roles.php"><button class="btn btn-primary" type="button">ManageRoles</button></a>
        </div>
        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role->getId(); ?>"><?php echo htmlspecialchars($role->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="create_user">Create User</button>
        </form>

        <h2>Existing Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->getId(); ?></td>
                        <td><?php echo htmlspecialchars($user->getName()); ?></td>
                        <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($user->getStatus()); ?></td>
                        <td>
                            <?php
                            if (isset($rolesArray[$user->getRoleId()])) {
                                echo htmlspecialchars($rolesArray[$user->getRoleId()]);
                            } else {
                                echo 'Role not found';
                            }
                            ?>
                        </td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user->getName()); ?>" required>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>
                                <input type="text" name="status" value="<?php echo htmlspecialchars($user->getStatus()); ?>" required>
                                <select name="role_id" required>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role->getId(); ?>" <?php echo $role->getId() == $user->getRoleId() ? 'selected' : ''; ?>><?php echo htmlspecialchars($role->getName()); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-warning btn-sm" name="update_user">Update</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                                <button type="submit" class="btn btn-danger btn-sm" name="delete_user">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
