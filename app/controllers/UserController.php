<?php
namespace app\controllers;
use core\controller;
use app\models\user;
use app\models\post;
use app\models\like;   
use core\session;


class UserController extends Controller {
    public function profile($username) {
        $userModel = new User();
        $profileUser = $userModel->findByUsername($username);

        if (!$profileUser) {
            $this->view('errors/404');
            return;
        }

        $postModel = new Post();
        $posts = $postModel->getByUserId($profileUser['id']);

        // Check likes for the currently logged-in user viewing this profile
        $likedPosts = [];
        if ($currentUser = Session::get('user')) {
            $likeModel = new Like();
            foreach($posts as $p) {
                if ($likeModel->hasLiked($currentUser['id'], $p['id'])) {
                    $likedPosts[$p['id']] = true;
                }
            }
        }

        // Pass 'likedPosts' to the view so the partial knows which hearts to paint red
        $this->view('user/profile', [
            'profileUser' => $profileUser,
            'posts' => $posts,
            'likedPosts' => $likedPosts 
        ]);
    }
}