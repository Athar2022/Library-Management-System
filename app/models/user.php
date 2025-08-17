<?php
namespace App\Models;

class User {
    use LoggingTrait;

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function addUser($username, $email, $password) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
            $this->logAction("User added: $username");
        } catch (\PDOException $e) {
            $this->logAction("Error adding user: " . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $this->logAction("User deleted: ID $id");
        } catch (\PDOException $e) {
            $this->logAction("Error deleting user: " . $e->getMessage());
        }
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}