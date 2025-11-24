<?php
namespace app\controllers;
use core\controller;
use app\models\post;
use app\models\like;
use core\session;

class HomeController extends Controller {
    public function index() {
        $postModel = new Post();
        $posts = $postModel->getAll();
        
        // Check likes if logged in
        $likedPosts = [];
        if ($user = Session::get('user')) {
            $likeModel = new Like();
            foreach($posts as $p) {
                if ($likeModel->hasLiked($user['id'], $p['id'])) {
                    $likedPosts[$p['id']] = true;
                }
            }
        }

        $this->view('home/index', ['posts' => $posts, 'likedPosts' => $likedPosts]);
    }
}