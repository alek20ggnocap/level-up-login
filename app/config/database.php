<?php
class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    public $conn;

    public function __construct() {
        $this->host = getenv("DB_HOST");
        $this->db   = getenv("DB_NAME");
        $this->user = getenv("DB_USER");
        $this->pass = getenv("DB_PASS");
    }

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
        return $this->conn;
    }
}