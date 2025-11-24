<?php
namespace app\models;
use core\model;

class Like extends Model {
    public function hasLiked($userId, $postId) {
        $stmt = $this->db->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$userId, $postId]);
        return $stmt->fetch() ? true : false;
    }

    public function toggle($userId, $postId) {
        if ($this->hasLiked($userId, $postId)) {
            $stmt = $this->db->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
            $stmt->execute([$userId, $postId]);
            return false; // Unliked
        } else {
            $stmt = $this->db->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
            $stmt->execute([$userId, $postId]);
            return true; // Liked
        }
    }
    
    public function count($postId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM likes WHERE post_id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch()['total'];
    }
}