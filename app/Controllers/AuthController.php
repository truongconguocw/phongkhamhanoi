<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Patient;
use PDOException;
use App\Services\MailService;
class AuthController extends BaseController
{
    /**
     * Hiển thị trang đăng nhập.
     */
    public function showLoginForm()
    {
        $this->render('auth/login');
    }

    /**
     * Xử lý yêu cầu đăng nhập từ form.
     */
    public function login()
    {
        // 1. Lấy dữ liệu từ POST
        $identifier = $_POST['identifier'] ?? '';
        $password = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']);
        // 2. Tìm người dùng trong CSDL
        $userModel = new User();
        $user = $userModel->findByIdentifier($identifier);

        // 3. Kiểm tra người dùng và mật khẩu
        if ($user && password_verify($password, $user['MatKhau'])) {
            // Đăng nhập thành công
            
            // Xóa mật khẩu khỏi mảng trước khi lưu vào session để bảo mật
            unset($user['MatKhau']); 
            
            // Lưu toàn bộ thông tin người dùng vào session
            $_SESSION['user'] = $user;

            // Hủy các thông báo lỗi cũ (nếu có)
            unset($_SESSION['error_message']);
            if ($rememberMe) {
                $this->createRememberMeToken($user['UserID']);
            }
            // Chuyển hướng đến trang chủ. 
            $this->redirect('/');
        } else {
            // Đăng nhập thất bại
            $_SESSION['error_message'] = 'Email/Số điện thoại hoặc mật khẩu không chính xác.';
            header('Location: /login');
            exit();
        }
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout()
    {
        // Xóa token "Ghi nhớ" nếu có
        if (isset($_COOKIE['remember_me'])) {
            list($selector, ) = explode(':', $_COOKIE['remember_me'], 2);
            $userModel = new User();
            $userModel->deleteAuthTokenBySelector($selector);
            setcookie('remember_me', '', time() - 3600, '/');
        }
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
    public function showRegisterForm()
    {
        $this->render('auth/register', ['title' => 'Đăng ký']);
    }

    /**
     * Xử lý yêu cầu gửi OTP qua AJAX.
     */
    public function sendOtp()
    {
        // Chỉ cho phép request AJAX
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die('Truy cập không hợp lệ.');
        }

        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? null;

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Địa chỉ email không hợp lệ.']);
            return;
        }

        // Tạo mã OTP (6 chữ số)
        $otp = rand(100000, 999999);

        // Lưu OTP và thời gian hết hạn vào session (5 phút)
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expires_at'] = time() + 300; // 5 phút * 60 giây

        // Gửi email
        $mailService = new MailService();
        if ($mailService->sendOtp($email, $otp)) {
            echo json_encode(['success' => true, 'message' => 'Mã OTP đã được gửi đến email của bạn.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể gửi email. Vui lòng thử lại sau.']);
        }
    }

    /**
     * Xử lý dữ liệu từ form đăng ký.
     */
    public function register()
    {
        // 1. Lấy dữ liệu từ POST
        $data = [
            'HoTen' => $_POST['HoTen'] ?? '',
            'NgaySinh' => $_POST['NgaySinh'] ?? '',
            'GioiTinh' => $_POST['GioiTinh'] ?? '',
            'Email' => $_POST['Email'] ?? '',
            'SoDienThoai' => $_POST['SoDienThoai'] ?? '',
            'MatKhau' => $_POST['MatKhau'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'otp' => $_POST['otp'] ?? ''
        ];

        // 2. Validate dữ liệu
        if (empty($data['HoTen']) || empty($data['Email']) || empty($data['MatKhau']) || empty($data['otp'])) {
            $_SESSION['error_message'] = 'Vui lòng điền đầy đủ thông tin bắt buộc, bao gồm cả mã OTP.';
            $this->redirect('/register');
        }
        // 2.1. Validate OTP
        if (
            empty($_SESSION['otp']) ||
            $data['otp'] != $_SESSION['otp'] ||
            $data['Email'] != $_SESSION['otp_email'] ||
            time() > $_SESSION['otp_expires_at']
        ) {
            $_SESSION['error_message'] = 'Mã OTP không hợp lệ, đã hết hạn hoặc không đúng với email. Vui lòng thử lại.';
            $this->redirect('/register');
        }

        if ($data['MatKhau'] !== $data['confirm_password']) {
            $_SESSION['error_message'] = 'Mật khẩu xác nhận không khớp.';
            $this->redirect('/register');
        }

        // 3. Xử lý tạo tài khoản
        $userModel = new User();
        
        try {
            // Băm mật khẩu
            $hashedPassword = password_hash($data['MatKhau'], PASSWORD_BCRYPT);

            // Tạo tài khoản trong bảng 'nguoidung'
            $newUserId = $userModel->create([
                'HoTen' => $data['HoTen'],
                'Email' => $data['Email'],
                'SoDienThoai' => $data['SoDienThoai'],
                'MatKhau' => $hashedPassword,
                'VaiTro' => 'BenhNhan' // Mặc định vai trò là Bệnh nhân
            ]);

            // Nếu tạo user thành công, tạo hồ sơ trong bảng 'benhnhan'
            if ($newUserId) {
                $patientModel = new Patient();
                $patientModel->create([
                    'UserID' => $newUserId,
                    'HoTen' => $data['HoTen'],
                    'NgaySinh' => $data['NgaySinh'],
                    'GioiTinh' => $data['GioiTinh'],
                    'SoDienThoai' => $data['SoDienThoai']
                ]);
            }

            // Chuyển hướng đến trang đăng nhập với thông báo thành công
            $_SESSION['success_message'] = 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.';
            $this->redirect('/login');

        } catch (PDOException $e) {
            // Bắt lỗi nếu email hoặc số điện thoại đã tồn tại (do UNIQUE constraint trong DB)
            if ($e->errorInfo[1] == 1062) { // 1062 là mã lỗi cho duplicate entry
                $_SESSION['error_message'] = 'Email hoặc Số điện thoại đã được sử dụng.';
            } else {
                $_SESSION['error_message'] = 'Đã có lỗi xảy ra. Vui lòng thử lại.';
            }
            $this->redirect('/register');
        }
    }

    /**
     * Tạo và lưu token "Ghi nhớ đăng nhập".
     * @param int $userId
     */
    private function createRememberMeToken(int $userId)
    {
        $userModel = new User();
        
        // Tạo selector và validator ngẫu nhiên
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));
        
        // Băm validator để lưu vào CSDL
        $validatorHash = password_hash($validator, PASSWORD_DEFAULT);
        
        // Thời gian hết hạn 30 ngày
        $expiresAt = date('Y-m-d H:i:s', time() + 86400 * 30);

        // Lưu token vào CSDL
        $userModel->createAuthToken($userId, $selector, $validatorHash, $expiresAt);

        // Tạo cookie
        $cookieValue = $selector . ':' . $validator;
        setcookie('remember_me', $cookieValue, time() + 86400 * 30, '/', '', false, true); // httpOnly = true
    }
}
