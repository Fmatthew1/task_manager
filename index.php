<?php
include 'Db.php';
include 'todo.php';

$todos = Todo::findAll($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
                <?php foreach ($todos as $todo) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($todo->getName()); ?></td>
                        <td><?php echo htmlspecialchars($todo->getIsCompleted() ? 'Completed' : 'Pending'); ?></td>
                        <td><?php echo htmlspecialchars($todo->getUserId() ? 'Assigned' : 'Unassigned'); ?></td>
                        <td><?php echo htmlspecialchars($todo->getCreatedAt()); ?></td>
                        <td><?php echo htmlspecialchars($todo->getCompletedAt() ? date('Y-m-d H:i:s', strtotime($todo->getCompletedAt())) : 'N/A'); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $todo->getId(); ?>" class="btn btn-sm btn-info">Update</a>
                            <?php if (!$todo->getIsCompleted()) { ?>
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
