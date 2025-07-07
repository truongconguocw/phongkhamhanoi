<?php

// Bắt đầu session cho toàn bộ ứng dụng
session_start();
// Tự động đăng nhập bằng cookie "Ghi nhớ"
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me'])) {
    list($selector, $validator) = explode(':', $_COOKIE['remember_me'], 2);

    if ($selector && $validator) {
        require_once __DIR__ . '/../app/Models/BaseModel.php';
        require_once __DIR__ . '/../app/Models/User.php';
        
        $userModel = new \App\Models\User();
        $user = $userModel->findUserByToken($selector, $validator);

        if ($user) {
            // Đăng nhập thành công, tạo lại session
            unset($user['MatKhau']);
            $_SESSION['user'] = $user;
        } else {
            // Token không hợp lệ, xóa cookie
            setcookie('remember_me', '', time() - 3600, '/');
        }
    }
}
// Nạp autoloader của Composer
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Core\Request;

try {
    // Nạp các định nghĩa route từ file routes.php
    // và điều hướng request đến đúng controller
    Router::load(__DIR__ . '/../routes.php')
          ->dispatch(Request::uri(), Request::method());
} catch (Exception $e) {
    echo '<h1>Lỗi</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
}
