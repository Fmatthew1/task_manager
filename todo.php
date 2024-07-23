<?php
class Todo {
    private $conn;
    private $name;
    private $is_completed;
    private $created_at;
    private $updated_at;
    private $id;
    private $completed_at;
    private $user_id;
    private $user;

    public function __construct($conn, $name, $is_completed, $created_at, $updated_at, $id = null, $completed_at = null, $user_id = null, $user = null) {
        $this->conn = $conn;
        $this->name = $name;
        $this->is_completed = $is_completed;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->id = $id;
        $this->completed_at = $completed_at;
        $this->user_id = $user_id;
        $this->user = $user;
    }

    public static function findAll($conn) {
        $sql = "SELECT * FROM todos";
        $result = $conn->query($sql);

        $todos = [];
        while ($row = $result->fetch_assoc()) {
            $user = User::find($conn, $row['user_id']); // Retrieve the User object
            $todos[] = new self(
                $conn,
                $row['name'],
                $row['is_completed'],
                $row['created_at'],
                $row['updated_at'],
                $row['id'],
                $row['completed_at'],
                $row['user_id'],
                $user
            );
        }
        return $todos;
    }

    public static function find($conn, $id) {
        $sql = "SELECT * FROM todos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            $user = User::find($conn, $row['user_id']); // Retrieve the User object
            return new self(
                $conn,
                $row['name'],
                $row['is_completed'],
                $row['created_at'],
                $row['updated_at'],
                $row['id'],
                $row['completed_at'],
                $row['user_id'],
                $user
            );
        } else {
            return null;
        }
    }

    public static function findById($conn, $id) {
        $sql = "SELECT * FROM todos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            $user = User::find($conn, $row['user_id']); // Retrieve the User object
            return new self(
                $conn,
                $row['name'],
                $row['is_completed'],
                $row['created_at'],
                $row['updated_at'],
                $row['id'],
                $row['completed_at'],
                $row['user_id'],
                $user
            );
        } else {
            return null;
        }
    }

    public function setUser($user){
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setIsCompleted($is_completed) {
        $this->is_completed = $is_completed;
    }

    public function getIsCompleted() {
        return $this->is_completed;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setCompletedAt($completed_at) {
        $this->completed_at = $completed_at;
    }

    public function getCompletedAt() {
        return $this->completed_at;
    }

   // Update todo
   public function update() {
    $sql = "UPDATE todos SET name = ?, is_completed = ?, user_id = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("siii", $this->name, $this->is_completed, $this->user_id, $this->id);
    return $stmt->execute();
}

public function complete() {
    
    $sql = "UPDATE todos SET is_completed = ?, completed_at = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        error_log("Failed to prepare statement: " . $this->conn->error);
        return false;
    }

    $stmt->bind_param("isi", $this->is_completed, $this->completed_at, $this->id);
    return $stmt->execute();
}

    public function create() {
        try {
            $sql = "INSERT INTO todos (name, is_completed, created_at, updated_at,  completed_at, user_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sisssi", $this->name, $this->is_completed, $this->created_at, $this->updated_at, $this->completed_at, $this->user_id);
            if ($stmt->execute()) {
                return true;
            } else {
                return "Error executing statement: " . $stmt->error;
            }
        } catch (Exception $e) {
            return "Exception: " . $e->getMessage();
        }
    }
    
    // User existence check
    private function userExists() {
        $sql = "SELECT id FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->store_result();
        var_dump($result);
        return $stmt->num_rows > 0;
    }
}
