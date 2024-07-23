<?php
class User {
    private $conn;
    private $id;
    private $name;
    private $email;
    private $password;
    private $status;
    private $role_id;

    public function __construct($conn, $name, $email, $password, $status, $role_id, $id = null) {
        $this->conn = $conn;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
        $this->role_id = $role_id;
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

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setRoleId($role_id){
        $this->role_id = $role_id;
    }
    public function getRoleId(){
        return $this->role_id;
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
            $user = new User($conn, $row['name'], $row['email'], $row['password'], $row['status'], $row['role_id'], $row['id']);
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
            $user = new User($conn, $row['name'], $row['email'], $row['password'], $row['status'], $row['role_id'], $row['id']);
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
                $row['password'],
                $row['status'],
                $row['role_id'],
                $row['id']
            );
        }
        return $users;
    }
    public static function findByEmail($conn, $email) {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            return new self(
                $conn,
                $row['name'],
                $row['email'],
                $row['password'],
                $row['status'],
                $row['role_id'],
                $row['id']
            );
        }
            return null;
        
    } 
    public static function emailExists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
        return $result->num_rows > 0;
    }
    // public function create() {
    //     $name = $this->conn->real_escape_string($this->name);
    //     $email = $this->conn->real_escape_string($this->email);
    //     $status = $this->status;
    //     $role_id = $this->role_id;
    //     $password = $this->password;

    //     $sql = "INSERT INTO users (name, email, role_id, password, status) VALUES (?, ?, ?, ?, ?)";
    //     $statement = $this->conn->prepare($sql);

    //     if ($statement === false) {
    //         error_log("Statement preparation failed: " . $this->conn->error);
    //         return false;
    //     }

    //     $statement->bind_param("ssiss", $name, $email, $role_id, $password, $status);

    //     if ($statement->execute()) {
    //         $this->id = $this->conn->insert_id;
    //         return true;
    //     } else {
    //         error_log("Statement execution failed: " . $statement->error);
    //         return false;
    //     }
    // } 

    public function create() {
        $name = $this->conn->real_escape_string($this->name);
        $email = $this->conn->real_escape_string($this->email);
        $status = $this->conn->real_escape_string($this->status);
        $role_id = $this->role_id;
        $password = $this->password;
    
        // Check if status is valid
        if (!in_array($status, ['active', 'inactive'])) {
            error_log("Invalid status: " . $status);
            return false;
        }
    
        $sql = "INSERT INTO users (name, email, role_id, password, status) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->conn->prepare($sql);
    
        if ($statement === false) {
            error_log("Statement preparation failed: " . $this->conn->error);
            return false;
        }
    
        $statement->bind_param("ssiss", $name, $email, $role_id, $password, $status);
    
        if ($statement->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        } else {
            error_log("Statement execution failed: " . $statement->error);
            return false;
        }
    }
    
    public function update() {
        $name = $this->conn->real_escape_string($this->name);
        $email = $this->conn->real_escape_string($this->email);
        $password = $this->password;
        $status = $this->status;
        $role_id = $this->role_id;

        $sql = "UPDATE users SET name = ?, email = ?, password = ?, status = ?, role_id = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $statement = $this->conn->prepare($sql);

        if ($statement === false) {
            error_log("Statement preparation failed: " . $this->conn->error);
            return false;
        }

        $statement->bind_param("ssssii", $name, $email, $password, $status, $this->role_id, $this->id);

        if ($statement->execute()) {
            return true;
        } else {
            error_log("Statement execution failed: " . $statement->error);
            return false;
        }
    }

    public function delete() {
        global $conn;

        // First, delete the associated todos
        $query = "DELETE FROM todos WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            // Now delete the user
            $query = "DELETE FROM users WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $this->id);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    //Toggle user status
    public function toggleStatus() {
        $this->status = ($this->status === 'active') ? 'inactive' : 'active';
        return $this->save();
    }
    
}

