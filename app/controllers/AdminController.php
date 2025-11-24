<?php
namespace app\controllers;
use core\controller;
use app\models\user;
use core\session;

class AdminController extends Controller {
    public function __construct() {
        $user = Session::get('user');
        // if (!$user || $user['role'] !== 'admin') {
        //     http_response_code(403);
        //     die("Access Denied");
        // }
    }

    public function dashboard() {
        $userModel = new User();
        $users = $userModel->getAll();
        $this->view('admin/dashboard', ['users' => $users]);
    }

    public function blockUser() {
        $this->validateCsrf();
        $userId = $_POST['user_id'];
        $action = $_POST['action']; // 'block' or 'unblock'
        
        $userModel = new User();
        $userModel->toggleBlock($userId, $action === 'block' ? 1 : 0);
        
        Session::setFlash('success', "User updated successfully.");
        $this->redirect('/admin');
    }
}