<?php
class UserModel{
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    function getUserByEmail($email)  {

            $query = "SELECT * FROM ". $this->table_name." where email = :email";
    
            $stmt = $this->conn->prepare($query);
            $stmt -> bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;
    }
    
    public function registerUser($email, $username, $password, $role = 'user') {
        $query  = "INSERT INTO users (email, username, password, role) VALUES (:email, :username, :password, :role)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR); 
    

        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
}