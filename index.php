<?php
session_start();
include 'Db.php';
include 'todo.php';
include 'users.php';

checkAuth();
checkRole('Todo Manager');


$todos = Todo::findAll($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Include the navbar here -->
    <div class="container mt-5">
        <h1>Todo List</h1>
        <a href="create.php" class="btn btn-primary mb-3">Create Todo</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Assigned User</th>
                    <th>Date Created</th>
                    <th>Date Completed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo) {
                
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($todo->getName()); ?></td>
                        <td><?php echo $todo->getIsCompleted() ? 'Completed' : 'Pending'; ?></td>
                        <td><?php echo htmlspecialchars($todo->getUser() ? $todo->getUser()->getName() : 'Unassigned'); ?></td>
                        <td><?php echo htmlspecialchars($todo->getCreatedAt()); ?></td>
                        <td><?php echo htmlspecialchars($todo->getCompletedAt() ? date('Y-m-d H:i:s', strtotime($todo->getCompletedAt())) : 'N/A'); ?></td>
                        <td>

                        <td>
                            <?php if (!$todo->getIsCompleted()) { ?>
                                <a href="update.php?id=<?php echo $todo->getId(); ?>" class="btn btn-sm btn-info">Update</a>
                                <a href="complete.php?id=<?php echo $todo->getId(); ?>" class="btn btn-sm btn-success">Complete</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
