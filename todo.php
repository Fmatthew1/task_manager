<?php
class Todo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function findAll() {
        $sql = "SELECT * FROM todos ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        $todos = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $todos[] = $row;
            }
        }
        return $todos;
    }

    public function find($id) {
        $sql = "SELECT * FROM todos WHERE id=$id";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function create($name) {
        $name = $this->conn->real_escape_string($name);
        $sql = "INSERT INTO todos (name) VALUES ('$name')";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $name) {
        $name = $this->conn->real_escape_string($name);
        $sql = "UPDATE todos SET name='$name', updated_at=NOW() WHERE id=$id";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function complete($id) {
        $sql = "UPDATE todos SET is_completed=TRUE, completed_at=NOW() WHERE id=$id";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}




