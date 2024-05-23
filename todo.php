<?php
class Todo {
    private $conn;
    private $id;
    private $name;
    private $is_completed;
    private $created_at;
    private $updated_at;
    private $completed_at;


    public function __construct($conn, $name, $is_completed, $created_at, $updated_at, $id, $completed_at) {
        $this->conn = $conn;
        $this->name = $name;
        $this->is_completed = $is_completed;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->id = $id;
        $this->completed_at = $completed_at;
       
    
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
        // var_dump($completed_at);
        // exit();
        $this->completed_at = $completed_at;
    }

    public function getCompletedAt() {
        return $this->completed_at;
    }

    public function save() {
        if ($this->id === null) {
            return $this->create();
        }   else {
            // var_dump($this->id);
            // exit();
            return $this->update();
        }
    }

        public static function findAll($conn) {
            $sql = "SELECT * FROM todos ORDER BY created_at DESC";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->get_result();
            $todos = [];
            while ($row = $result->fetch_assoc()) {
                $todo = new Todo($conn, $row['name'], $row['is_completed'], $row['created_at'], $row['updated_at'], $row['id'], $row['completed_at']);
                $todos[] = $todo;
            }
           
            return $todos;
        }

        public static function find($conn, $id) {
            $sql = "SELECT * FROM todos WHERE id=?";
            $statement = $conn->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $todo = new Todo($conn, $row['name'], $row['is_completed'], $row['created_at'], $row['updated_at'], $row['id'], $row['completed_at']);
        
            } 
                return $todo;
            
        }

        public function create() {
            // Escape the name to prevent SQL injection
            $name = $this->conn->real_escape_string($this->name);
        
            // Ensure the datetime values are properly formatted
            $created_at = date('Y-m-d H:i:s', strtotime($this->created_at));
            $updated_at = date('Y-m-d H:i:s', strtotime($this->updated_at));
        
            // Prepare the SQL statement
            $sql = "INSERT INTO todos (name, is_completed, created_at, updated_at) VALUES (?, ?, ?, ?)";
            $statement = $this->conn->prepare($sql);
        
            if ($statement === false) {
                // Handle error if statement preparation fails
                error_log("Statement preparation failed: " . $this->conn->error);
                return false;
            }
        
            // Bind parameters to the prepared statement
            $statement->bind_param("siss", $name, $this->is_completed, $created_at, $updated_at);
           
            // Execute the statement
            if ($statement->execute()) {
                // If execution is successful, set the ID property
                $this->id = $this->conn->insert_id;
                return true;
            } else {
                // If execution fails, return false
                error_log("Statement execution failed: " . $statement->error);
                return false;
            }
        }
        
        
        public function update() {
   
            // Check if the task is completed and set completed_at accordingly
            if ($this->is_completed) {
                $sql = "UPDATE todos SET is_completed = ?, completed_at = CURRENT_TIMESTAMP, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            } else {
                $sql = "UPDATE todos SET name = ?, is_completed = ?, completed_at = NULL, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            }
        
            // Prepare the SQL statement
            $statement = $this->conn->prepare($sql);
        
            // Bind parameters to the prepared statement
            $statement->bind_param("sii", $this->name, $this->is_completed, $this->id);
        
            // Execute the statement
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

   
