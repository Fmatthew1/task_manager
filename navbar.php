<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="list-unstyled ms-3">
        <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item">
            <button class="btn btn-sm btn-outline-info me-2" type="button"><a class = "nav-link" href="logout.php">Logout</a></button>
        </li>
        <?php else: ?>
            <li class="nav-item">
            <button class="btn btn-sm btn-outline-info me-2" type="button"><a class="nav-link" href="login.php">Login</a></button>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Task Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <button class="btn btn-sm btn-outline-success me-2" type="button"><a class="nav-link" href="index.php">Todos</a></button>
                </li>
                <li class="nav-item">
                <button class="btn btn-sm btn-outline-success me-2" type="button"><a class="nav-link" href="home.php">Users</a></button>
                </li>
                <li class="nav-item">
                <button class="btn btn-sm btn-outline-success" type="button"><a class="nav-link" href="manage_roles.php">Roles</a></button>
                </li>
            </ul>
        </div>
    </div>
</nav>
