<?php
namespace app\models;
use core\model;

class User extends Model {
    public function create($username, $email, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hash]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT id, username, email, role, blocked, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function toggleBlock($userId, $blockStatus) {
        $stmt = $this->db->prepare("UPDATE users SET blocked = ? WHERE id = ?");
        return $stmt->execute([$blockStatus, $userId]);
    }
}