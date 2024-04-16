<!DOCTYPE html>
<html>
<head>
    <title>Create Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Todo</h1>
        <form action="create_process.php" method="POST">
            <div class="form-group">
                <label for="name">Todo Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
