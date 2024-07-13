<?php
Class Role {
    private $conn;
    private $name;
    private $id;    

    public function __construct($conn, $name, $id = null) {
        $this->conn = $conn;
        $this->name = $name;
        $this->id = $id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setName($name){
        $this->name = $name;
    }
 
    public function getName(){
        return $this->name;
    }

    public static function findAll($conn) {
        $sql = "SELECT * FROM roles";
        $result = $conn->query($sql);

        $roles = [];
        while ($row = $result->fetch_assoc()) {
            $roles[] = new self($conn, $row['name'], $row['id']);
        }
        return $roles;
    }

    public static function find($conn, $id) {
        $sql = "SELECT * FROM roles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            return new self($conn, $row['name'], $row['id']);
        } else {
            return null;
        }
    }

    public static function roleExists($conn, $name) {
        $sql = "SELECT * FROM roles WHERE name = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        return $result->num_rows > 0;
    }

    public function create() {
        if (self::roleExists($this->conn, $this->name)) {
            return false;
        }

        $name = $this->conn->real_escape_string($this->name);
        $sql = "INSERT INTO roles (name) VALUES (?)";
        $statement = $this->conn->prepare($sql);

        if ($statement === false) {
            error_log("Statement preparation failed: " . $this->conn->error);
            return false;
        }

        $statement->bind_param("s", $name);

        if ($statement->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        } else {
            error_log("Statement execution failed: " . $statement->error);
            return false;
        }
    }
    public function update() {
        if (empty($this->name)) {
            return false; // Validation: Role name cannot be empty
        }

        $name = $this->conn->real_escape_string($this->name);
        $sql = "UPDATE roles SET name = ? WHERE id = ?";
        $statement = $this->conn->prepare($sql);

        if ($statement === false) {
            error_log("Statement preparation failed: " . $this->conn->error);
            return false;
        }

        $statement->bind_param("si", $name, $this->id);

        if ($statement->execute()) {
            return true;
        } else {
            error_log("Statement execution failed: " . $statement->error);
            return false;
        }
    }
    public function delete() {
        $sql = "DELETE FROM roles WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

}