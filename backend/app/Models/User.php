<?php


class User {
    private $conn;
    private $table_name = "users";
    private $pepper = "examplePepperForWalaLang";

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    //method to check if the username already exists
    public function usernameExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        //bind the username parameter
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
        
        //iff a row is returned, the username exists
        if ($stmt->rowCount() > 0) {
            return true;
        }
        
        return false;
    }

    //registration method
    public function register() {
        //first, check if the userrname already exists
        if ($this->usernameExists()) {
            return false; //usernameexists, return false
        }

        //proceed to insert the new user
        $query = "INSERT INTO " . $this->table_name . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);

        //bind the username parameter
        $stmt->bindParam(":username", $this->username);
        
        //combine the password with the pepper before hashing
        $pepperedPassword = $this->password . $this->pepper;

        //hash the peppered password using bcrypt (salt is automatically managed by password_hash)
        $hashedPassword = password_hash($pepperedPassword, PASSWORD_BCRYPT);

        //bind the hashed password parameter
        $stmt->bindParam(":password", $hashedPassword);

        //execute the statement and return success status
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //login method
    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            //combine the input password with the same pepper
            $pepperedPassword = $this->password . $this->pepper;

            //verify the peppered password against the stored hashed password
            if (password_verify($pepperedPassword, $user['password'])) {
                return $user; //login successful
            }
        }

        return false; //login failed
    }
}


?>
