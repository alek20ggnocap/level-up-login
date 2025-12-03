<?php
class AccessLog {
    private $conn;
    private $table = "access_logs";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function loginEvent($userId, $workstation) {
        $sql = "INSERT INTO $this->table (user_id, login_time, workstation) 
                VALUES (:uid, NOW(), :ws)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["uid" => $userId, "ws" => $workstation]);
    }

    public function logoutEvent($sessionId) {
        $sql = "UPDATE $this->table SET logout_time = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $sessionId]);
    }
}