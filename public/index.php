<?php
require_once __DIR__ . '/../config/config.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = '';
    $base_dir = __DIR__ . '/../';
    
    // Handle namespace mapping
    $class = str_replace('App\\', 'app\\', $class);
    $class = str_replace('Core\\', 'core\\', $class);
    
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

use core\router;
use core\session;
use app\controllers\HomeController;
use app\controllers\PostController;
use app\controllers\AuthController;
use app\controllers\UserController;
use app\controllers\AdminController;

Session::start();

$router = new Router();

// Routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/post/{id}-{slug}', [PostController::class, 'viewPost']);
$router->post('/post/like', [PostController::class, 'like']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/user/{username}', [UserController::class, 'profile']);

$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin/block', [AdminController::class, 'blockUser']);

$router->resolve();