<?php
namespace app\controllers;
use core\controller;
use core\session;
use app\models\user;

class AuthController extends Controller {
    public function showLogin() {
        if (Session::get('user')) $this->redirect('/');
        $this->view('auth/login');
    }

    public function login() {
        $this->validateCsrf();
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['blocked']) {
                Session::setFlash('error', 'Your account has been blocked. Contact support.');
                $this->redirect('/login');
            }
            
            // Simple login rate limit could go here (using session counter)
            Session::set('user', [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]);
            $this->redirect('/');
        } else {
            Session::setFlash('error', 'Invalid email or password.');
            $this->redirect('/login');
        }
    }

    public function showRegister() {
        if (Session::get('user')) $this->redirect('/');
        $this->view('auth/register');
    }

    public function register() {
        $this->validateCsrf();
        $username = trim($_POST['username']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (strlen($password) < 8) {
            Session::setFlash('error', 'Password must be at least 8 characters.');
            $this->redirect('/register');
        }

        $userModel = new User();
        if ($userModel->findByEmail($email) || $userModel->findByUsername($username)) {
            Session::setFlash('error', 'Username or Email already registered.');
            $this->redirect('/register');
        }

        if ($userModel->create($username, $email, $password)) {
            Session::setFlash('success', 'Registration successful! Please login.');
            $this->redirect('/login');
        }
    }

    public function logout() {
        Session::destroy();
        $this->redirect('/login');
    }
}