<?php
include 'Db.php';
include 'users.php';
include 'roles.php';

$name = $email = "";
$errorMessages = ["name" => "", "email" => "", "password" => "", "general" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $status = 'active';

    if (empty($name)) {
        $errorMessages['name'] = "Name is required.";
    }

    if (empty($email)) {
        $errorMessages['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages['email'] = "Invalid email format.";
    } else {
        $existingUser = User::findByEmail($conn, $email);
        if ($existingUser && (!isset($user) || $existingUser->getId() !== $user->getId())) {
            $errorMessages['email'] = "Error: Email already exists.";
        }
    }

    if (empty($password) && isset($_POST['create_user'])) {
        $errorMessages['password'] = "Password is required.";
    }

    if (empty($errorMessages['name']) && empty($errorMessages['email']) && empty($errorMessages['password'])) {
        if (isset($_POST['create_user'])) {
            $user = new User($conn, $_POST['name'], $_POST['email'], $_POST['password'], $_POST['status'], $_POST['role_id']);
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
        } elseif (isset($_POST['toggle_status']) && isset($_POST['id'])) {
            $user = User::find($conn, $_POST['id']);
            if ($user) {
                $user->toggleStatus();
            }
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
            <a href="manage_roles.php"><button class="btn btn-primary" type="button">Manage Roles</button></a>
        </div>
        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <?php if (!empty($errorMessages['name'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                    <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <?php if(!empty($errorMessages['email'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['email']; ?></div>
                    <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <?php if(!empty($errorMessages['password'])): ?>
                    <div class = "text-danger mt-2"><?php echo $errorMessages['password']; ?></div>
                    <?php endif; ?>
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
            <?php if (!empty($errorMessages['general'])): ?>
                <div class="text-danger mb-3"><?php echo $errorMessages['general']; ?></div>
            <?php endif; ?>
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
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user->getId(); ?>">Edit</button>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                                <button type="submit" class="btn btn-danger btn-sm" name="delete_user">Delete</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                                <button type="submit" class="btn btn-secondary btn-sm" name="toggle_status">
                                    <?php echo $user->getStatus() === 'active' ? 'Deactivate' : 'Activate'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal<?php echo $user->getId(); ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?php echo $user->getId(); ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel<?php echo $user->getId(); ?>">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user->getName()); ?>" required>
                                            <?php if (!empty($errorMessages['name'])): ?>
                                            <div class="text-danger mt-2"><?php echo $errorMessages['name']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>
                                            <?php if (!empty($errorMessages['email'])): ?>
                                            <div class="text-danger mt-2"><?php echo $errorMessages['email']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <input type="text" class="form-control" name="status" value="<?php echo htmlspecialchars($user->getStatus()); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Role</label>
                                            <select class="form-control" name="role_id" required>
                                                <?php foreach ($roles as $role): ?>
                                                    <option value="<?php echo $role->getId(); ?>" <?php echo $role->getId() == $user->getRoleId() ? 'selected' : ''; ?>><?php echo htmlspecialchars($role->getName()); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="update_user">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
