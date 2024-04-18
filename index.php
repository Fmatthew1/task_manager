<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class

$todo = new Todo($conn); // Create a new Todo instance

$todos = $todo->findAll(); // Get all todos

?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Todo List</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="create.php"><button class="btn btn-primary" type="button">Create</button></a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Date Completed</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo) { ?>
                    <tr>
                        <td><?php echo $todo->name; ?></td>
                        <td><?php echo $todo->is_completed ? 'Completed' : 'Pending'; ?></td>
                        <td><?php echo $todo->created_at; ?></td>
                        <td><?php echo $todo->completed_at; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $todo->id; ?>" class="btn btn-sm btn-info">Update</a>
                            <?php if (!$todo->is_completed) { ?>
                                <a href="complete.php?id=<?php echo $todo->id; ?>" class="btn btn-sm btn-success">Complete</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
