<?php
class Todo {
    private $conn;
    private $id;
    private $name;
    private $is_completed;
    private $created_at;
    private $updated_at;
    private $completed_at;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setIsCompleted($is_completed) {
        $this->is_completed = $is_completed;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function setCompletedAt($completed_at) {
        $this->completed_at = $completed_at;
    }

    public function save() {
        if ($this->id === null) {
            return $this->create($this->name);
        } else {
            return $this->update();
        }
    }

        public function findAll() {
            $sql = "SELECT * FROM todos ORDER BY created_at DESC";
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $result = $statement->get_result();
            $todos = [];
            while ($row = $result->fetch_object()) {
                $todos[] = $row;
            }
            return $todos;
        }

        public function find($id) {
            $sql = "SELECT * FROM todos WHERE id=?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($result->num_rows == 1) {
                return $result->fetch_object();
            } else {
                return null;
            }
        }

        public function create($name) {
            if (empty($name)) {
                return false; // Return false if name is empty
            }
            $name = $this->conn->real_escape_string($name);
            $sql = "INSERT INTO todos (name) VALUES (?)";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("s", $name);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }
        


    public function update() {
        $sql = "UPDATE todos SET name=?, is_completed=?, updated_at=NOW(), completed_at=? WHERE id=?";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param("sisi", $this->name, $this->is_completed, $this->completed_at, $this->id);
        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function complete() {
        $this->is_completed = true;
        $this->completed_at = date("Y-m-d H:i:s");
        return $this->save();
    }

    public function findById($id) {
        $sql = "SELECT id, name, is_completed, created_at, updated_at, completed_at FROM todos WHERE id=?";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_object();
            $this->id = $row->id;
            $this->name = $row->name;
            $this->is_completed = $row->is_completed;
            $this->created_at = $row->created_at;
            $this->updated_at = $row->updated_at;
            $this->completed_at = $row->completed_at;
            return true;
        } else {
            return false;
        }
    }

}

   
