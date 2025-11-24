<?php

namespace Core;

abstract class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        // Output buffering to capture view content
        ob_start();
        require __DIR__ . "/../app/Views/{$view}.php";
        $content = ob_get_clean();
        require __DIR__ . "/../app/views/layout/main.php";
    }

    protected function redirect($url)
    {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function validateCsrf()
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!Session::verifyCsrf($token)) {
            die("CSRF Token Validation Failed");
        }
    }
}
