<?php
include 'Db.php';
include 'users.php';
include 'roles.php';

$name = "";
$errorMessages = ["name" => "", "general" => ""];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_role'])) {
        $roleName = $_POST['name'];

        // Server-side validation for empty value
        if (empty($roleName)) {
            $errorMessages['name'] = "Name is required.";
        } elseif (Role::roleExists($conn, $roleName)) {
            $errorMessages['name'] = 'Role name already exists. Please choose a different name.';
        } else {
            $role = new Role($conn, $roleName);
            if ($role->create()) {
                $success = 'Role created successfully!';
            } else {
                $errorMessages['name'] = 'Failed to create role. Please try again.';
            }
        }
    }

    if (isset($_POST['update_role']) && isset($_POST['id'])) {
        $roleId = $_POST['id'];
        $roleName = trim($_POST['name']);
        $role = Role::find($conn, $roleId);

        if ($role) {
            // Server-side validation for empty value
            if (empty($roleName)) {
                $errorMessages['name'] = 'Role name cannot be empty.';
            } elseif (Role::roleExists($conn, $roleName) && $roleName !== $role->getName()) {
                $errorMessages['name'] = 'Role name already exists. Please choose a different name.';
            } else {
                $role->setName($roleName);
                if ($role->update()) {
                    $success = 'Role updated successfully!';
                } else {
                    $errorMessages['name'] = 'Failed to update role. Please try again.';
                }
            }
        } else {
            $errorMessages['general'] = 'Error updating role.';
        }
    }

    if (isset($_POST['delete_role']) && isset($_POST['id'])) {
        $role = Role::find($conn, $_POST['id']);
        if ($role) {
            if ($role->delete()) {
                $success = 'Role deleted successfully!';
            } else {
                $errorMessages['general'] = 'Failed to delete role. Please try again.';
            }
        }
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
            <a href="manage_users.php"><button class="btn btn-primary" type="button">Manage Users</button></a>
            <a href="home.php"><button class="btn btn-primary" type="button">Home</button></a>
        </div>

        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name">
                <?php if (!empty($errorMessages['name'])): ?>
                <div class="text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success mt-2"><?php echo $success; ?></div>
                <?php endif; ?>
            </div>
            <?php if (!empty($errorMessages['general'])): ?>
                <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary" name="create_role">Create Role</button>
        </form>

        <h2>Existing Roles</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $index => $role): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($role->getName()); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $role->getId(); ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($role->getName()); ?>" required>
                            <button type="submit" class="btn btn-info btn-sm" name="update_role">Update</button>
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




