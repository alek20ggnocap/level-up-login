<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM $this->table WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["username" => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $sql = "INSERT INTO $this->table (username, password_hash) VALUES (:u, :p)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            "u" => $this->username,
            "p" => password_hash($this->password, PASSWORD_BCRYPT)
        ]);
    }
}