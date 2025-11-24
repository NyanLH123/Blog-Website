<?php
namespace app\models;
use core\model;

class Post extends Model {
    public function getAll() {
        $sql = "SELECT p.*, u.username, 
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getByUserId($userId) {
        $sql = "SELECT p.*, u.username, 
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.user_id = ? ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}