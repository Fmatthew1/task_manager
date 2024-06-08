<?php
include 'Db.php'; // Include the database connection script
include 'todo.php'; // Include the Todo class
include 'users.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = intval($_GET['id']);

    if ($id > 0) {
        $completed_at = date("Y-m-d H:i:s");
        $todo = Todo::findById($conn, $id);

        if ($todo) {
            $todo->setIsCompleted(1);
            $todo->setCompletedAt($completed_at);

            if ($todo->complete()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error completing todo";
            }
        } else {
            echo "Todo not found";
        }
    } else {
        echo "Invalid ID";
    }
}
