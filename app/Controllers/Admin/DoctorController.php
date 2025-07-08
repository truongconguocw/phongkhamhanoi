<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Specialty;

class DoctorController extends BaseController
{
    private Doctor $doctorModel;
    private User $userModel;
    private Specialty $specialtyModel;

    public function __construct()
    {
        // Middleware: Chỉ Admin mới có quyền truy cập
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'QuanTri') {
            $this->redirect('/login');
            exit();
        }
        
        // Khởi tạo các model để tái sử dụng trong class
        $this->doctorModel = new Doctor();
        $this->userModel = new User();
        $this->specialtyModel = new Specialty();
    }

    /**
     * Hiển thị danh sách tất cả bác sĩ.
     */
    public function index()
    {
        $doctors = $this->doctorModel->getAllDoctorsForAdmin();

        $this->render('admin/doctors/index', [
            'title' => 'Quản lý Bác sĩ',
            'doctors' => $doctors
        ], 'admin');
    }

    /**
     * Hiển thị form để tạo bác sĩ mới.
     */
    public function create()
    {
        $specialties = $this->specialtyModel->findAll('TenChuyenKhoa ASC');

        $this->render('admin/doctors/create', [
            'title' => 'Thêm Bác sĩ mới',
            'specialties' => $specialties
        ], 'admin');
    }

    /**
     * Lưu bác sĩ mới vào CSDL.
     */
    public function store()
    {
        $db = (\Core\Database::getInstance())->getConnection();
        $db->beginTransaction();

        try {
            // 1. Tạo tài khoản trong bảng `nguoidung`
            $userId = $this->userModel->create([
                'HoTen' => $_POST['HoTen'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai'] ?: null,
                'MatKhau' => password_hash($_POST['MatKhau'], PASSWORD_DEFAULT),
                'VaiTro' => 'BacSi',
                'HoatDong' => 1
            ]);

            // 2. Tạo hồ sơ trong bảng `bacsi`
            $this->doctorModel->create([
                'UserID' => $userId,
                'ChuyenKhoaID' => !empty($_POST['ChuyenKhoaID']) ? $_POST['ChuyenKhoaID'] : null,
                'KinhNghiem' => $_POST['KinhNghiem'],
                'MoTa' => $_POST['MoTa']
            ]);

            $db->commit();
            $_SESSION['success_message'] = 'Thêm bác sĩ mới thành công!';
        } catch (\Exception $e) {
            $db->rollBack();
            $_SESSION['error_message'] = 'Lỗi khi thêm bác sĩ: ' . $e->getMessage();
        }

        $this->redirect('/admin/doctors');
    }

    /**
     * Hiển thị form chỉnh sửa thông tin bác sĩ.
     * @param int $id ID của bác sĩ (BacSiID)
     */
    public function edit(int $id)
    {
        $doctor = $this->doctorModel->find($id);
        if (!$doctor) {
            $_SESSION['error_message'] = 'Không tìm thấy bác sĩ.';
            $this->redirect('/admin/doctors');
            return;
        }

        $user = $this->userModel->find($doctor['UserID']);
        $specialties = $this->specialtyModel->findAll('TenChuyenKhoa ASC');

        $this->render('admin/doctors/edit', [
            'title' => 'Chỉnh sửa Bác sĩ',
            'doctor' => $doctor,
            'user' => $user,
            'specialties' => $specialties
        ], 'admin');
    }

    /**
     * Cập nhật thông tin bác sĩ trong CSDL.
     * @param int $id ID của bác sĩ (BacSiID)
     */
    public function update(int $id)
    {
        $doctor = $this->doctorModel->find($id);
        if (!$doctor) {
            $_SESSION['error_message'] = 'Không tìm thấy bác sĩ để cập nhật.';
            $this->redirect('/admin/doctors');
            return;
        }

        try {
            // 1. Cập nhật bảng `nguoidung`
            $userData = [
                'HoTen' => $_POST['HoTen'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai'] ?: null,
                'HoatDong' => $_POST['HoatDong'] ?? 0
            ];
            if (!empty($_POST['MatKhau'])) {
                $userData['MatKhau'] = password_hash($_POST['MatKhau'], PASSWORD_DEFAULT);
            }
            $this->userModel->update($doctor['UserID'], $userData);

            // 2. Cập nhật bảng `bacsi`
            $doctorData = [
                'ChuyenKhoaID' => !empty($_POST['ChuyenKhoaID']) ? $_POST['ChuyenKhoaID'] : null,
                'KinhNghiem' => $_POST['KinhNghiem'],
                'MoTa' => $_POST['MoTa']
            ];
            $this->doctorModel->update($id, $doctorData);

            $_SESSION['success_message'] = 'Cập nhật thông tin bác sĩ thành công!';
        } catch (\Exception $e) {
            $_SESSION['error_message'] = 'Lỗi khi cập nhật: ' . $e->getMessage();
        }

        $this->redirect('/admin/doctors');
    }

    /**
     * Xóa một bác sĩ khỏi CSDL.
     * @param int $id ID của bác sĩ (BacSiID)
     */
    public function destroy(int $id)
    {
        $doctor = $this->doctorModel->find($id);
        if (!$doctor) {
            $_SESSION['error_message'] = 'Không tìm thấy bác sĩ để xóa.';
            $this->redirect('/admin/doctors');
            return;
        }

        $db = (\Core\Database::getInstance())->getConnection();
        $db->beginTransaction();

        try {
            // Xóa trong bảng `bacsi` trước (bảng con)
            $this->doctorModel->delete($id);

            // Sau đó xóa trong bảng `nguoidung` (bảng cha)
            $this->userModel->delete($doctor['UserID']);

            $db->commit();
            $_SESSION['success_message'] = 'Đã xóa bác sĩ thành công.';
        } catch (\Exception $e) {
            $db->rollBack();
            $_SESSION['error_message'] = 'Lỗi khi xóa bác sĩ. Có thể bác sĩ này đã có dữ liệu liên quan (lịch hẹn, lịch làm việc...).';
        }

        $this->redirect('/admin/doctors');
    }
}