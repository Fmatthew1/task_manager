<?php
class User {
    private $conn;
    private $id;
    private $name;
    private $email;
    private $status;

    public function __construct($conn, $name, $email, $status, $id = null) {
        $this->conn = $conn;
        $this->name = $name;
        $this->email = $email;
        $this->status = $status;
        $this->id = $id;

    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function save() {
        if ($this->id === null) {
            return $this->create();
        } else {
            return $this->update();
        }
    }
    public static function findAll($conn) {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = new User($conn, $row['name'], $row['email'], $row['status'], $row['id']);
            $users[] = $user;
        }
        return $users;
    }
    public static function find($conn, $id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user = new User($conn, $row['name'], $row['email'], $row['status'], $row['id']);
            return $user;
        } else {
            return null;
        }
    }

    public static function findAllActive($conn) {
        $sql = "SELECT * FROM users WHERE status = 'active' ";
        $result = $conn->query($sql);
        $users = [];
        while($row = $result->fetch_assoc()){
            $users[] = new self(
                $conn,
                $row['name'],
                $row['email'],
                $row['status'],
                $row['id']
            );
        }
        return $users;
    }
    public static function emailExists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
        return $result->num_rows > 0;
    }
    private function create() {
        $name = $this->conn->real_escape_string($this->name);
        $email = $this->conn->real_escape_string($this->email);
        $status = $this->status;

        $sql = "INSERT INTO users (name, email, status) VALUES (?, ?, ?)";
        $statement = $this->conn->prepare($sql);

        if ($statement === false) {
            error_log("Statement preparation failed: " . $this->conn->error);
            return false;
        }

        $statement->bind_param("sss", $name, $email, $status);

        if ($statement->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        } else {
            error_log("Statement execution failed: " . $statement->error);
            return false;
        }
    }
    private function update() {
        $name = $this->conn->real_escape_string($this->name);
        $email = $this->conn->real_escape_string($this->email);
        $status = $this->status;

        $sql = "UPDATE users SET name = ?, email = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $statement = $this->conn->prepare($sql);

        if ($statement === false) {
            error_log("Statement preparation failed: " . $this->conn->error);
            return false;
        }

        $statement->bind_param("sssi", $name, $email, $status, $this->id);

        if ($statement->execute()) {
            return true;
        } else {
            error_log("Statement execution failed: " . $statement->error);
            return false;
        }
    }

    // Toggle user status
    public function toggleStatus() {
        $this->status = ($this->status === 'active') ? 'inactive' : 'active';
        return $this->save();
    }
}

