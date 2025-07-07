<?php
namespace App\Controllers;
use App\Models\Doctor;

/**
 * Class HomeController
 * Xử lý trang chủ và điều hướng người dùng đến dashboard phù hợp sau khi đăng nhập.
 */
class HomeController extends BaseController
{
    /**
     * Hiển thị trang chủ hoặc dashboard tương ứng với vai trò người dùng.
     *
     * - Nếu người dùng chưa đăng nhập, chuyển hướng đến trang login.
     * - Nếu đã đăng nhập, kiểm tra vai trò (QuanTri, BacSi, BenhNhan)
     *   và render view dashboard tương ứng.
     */
    public function index()
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user'])) {
            // Nếu chưa, chuyển hướng đến trang đăng nhập
            header('Location: /login');
            exit();
        }

        // 2. Lấy thông tin người dùng từ session
        $user = $_SESSION['user'];
        $role = $user['VaiTro']; // Lấy vai trò từ CSDL đã lưu trong session

        // 3. Điều hướng dựa trên vai trò
        switch ($role) {
            case 'QuanTri':
                // Nếu là Quản trị viên, chuyển hướng đến dashboard của admin
                $this->redirect('/admin/dashboard');
                break;

            case 'BacSi':
                $this->redirect('/doctor/dashboard');
                break;

            case 'BenhNhan':
                // Nếu là Bệnh nhân, hiển thị dashboard của bệnh nhân
                $this->render('dashboards/patient', [
                    'title' => 'Thông tin tài khoản',
                    'user' => $user
                ]);
                break;

            default:
                // Nếu vai trò không xác định, đăng xuất và về trang login để an toàn
                session_unset();
                session_destroy();
                header('Location: /login');
                exit();
        }
    }

    /**
     * Hiển thị trang danh sách bác sĩ công khai cho bệnh nhân.
     */
    public function listDoctors()
    {
        $doctorModel = new Doctor();
        $doctors = $doctorModel->getAllWithSpecialty();

        $this->render('doctors_list', [
            'title' => 'Danh sách Bác sĩ',
            'doctors' => $doctors
        ]);
    }
}