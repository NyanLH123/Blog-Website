<?php
namespace app\controllers;
use core\controller;
use app\models\post;
use app\models\like;
use core\session;

class PostController extends Controller {
    public function viewPost($id, $slug) {
        $postModel = new Post();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $likeModel = new Like();
        $isLiked = false;
        $user = Session::get('user');
        if ($user) {
            $isLiked = $likeModel->hasLiked($user['id'], $id);
        }
        $likeCount = $likeModel->count($id);

        $this->view('post/view', [
            'post' => $post, 
            'isLiked' => $isLiked, 
            'likeCount' => $likeCount
        ]);
    }

    public function like() {
        header('Content-Type: application/json');
        
        $user = Session::get('user');
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Login required']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $postId = $data['postId'] ?? null;
        $token = $data['csrf_token'] ?? '';

        if (!Session::verifyCsrf($token)) {
             echo json_encode(['success' => false, 'message' => 'Invalid Token']);
             return;
        }

        if ($postId) {
            $likeModel = new Like();
            $status = $likeModel->toggle($user['id'], $postId);
            $count = $likeModel->count($postId);
            echo json_encode(['success' => true, 'liked' => $status, 'count' => $count]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid Post']);
        }
    }
}