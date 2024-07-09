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
        // var_dump($sql);
        // exit;

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

    public function create() {
        $sql = "INSERT INTO roles (name) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->name);
        return $stmt->execute();
    }

    public function update() {
        $sql = "UPDATE roles SET name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->name, $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM roles WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

}