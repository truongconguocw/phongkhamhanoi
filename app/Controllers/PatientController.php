<?php

namespace App\Controllers;

use App\Models\Patient;
use App\Models\Appointment;

class PatientController extends BaseController
{

    /**
     * Hiển thị trang hồ sơ cá nhân của bệnh nhân.
     */
    public function showProfile()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BenhNhan') {
            $this->redirect('/login');
        }

        $patientModel = new Patient();
        $patientProfile = $patientModel->findByUserId($_SESSION['user']['UserID']);

        if (!$patientProfile) {
            die('Lỗi: Không tìm thấy hồ sơ bệnh nhân tương ứng.');
        }

        $this->render('patients/profile', [
            'title' => 'Hồ sơ cá nhân',
            'patient' => $patientProfile,
            'user' => $_SESSION['user']
        ]);
    }

    /**
     * Xử lý việc cập nhật hồ sơ cá nhân của bệnh nhân.
     */
    public function updateProfile()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BenhNhan') {
            $this->redirect('/login');
        }

        $patientModel = new Patient();
        $patientInfo = $patientModel->findByUserId($_SESSION['user']['UserID']);

        if ($patientInfo) {
            $dataToUpdate = [
                'NgaySinh' => $_POST['NgaySinh'] ?? null,
                'GioiTinh' => $_POST['GioiTinh'] ?? null,
                'DiaChi' => $_POST['DiaChi'] ?? ''
            ];

            $patientModel->update($patientInfo['BenhNhanID'], $dataToUpdate);
            $_SESSION['success_message'] = 'Cập nhật hồ sơ thành công!';
        } else {
            $_SESSION['error_message'] = 'Không thể cập nhật hồ sơ.';
        }

        $this->redirect('/patient/profile');
    }

    /**
     * Hiển thị trang lịch sử khám bệnh của một bệnh nhân cụ thể.
     * @param int $id ID của bệnh nhân từ URL.
     */
    public function showHistory(int $id)
    {
        $patientModel = new Patient();
        $patient = $patientModel->find($id);

        if (!$patient) {
            die('Không tìm thấy bệnh nhân.');
        }

        $appointmentModel = new Appointment();
        $appointments = $appointmentModel->findAllBy('BenhNhanID', $id, 'ThoiGianKham DESC');

        $this->render('patients/history', [
            'title' => 'Lịch sử khám bệnh: ' . $patient['HoTen'],
            'patient' => $patient,
            'appointments' => $appointments
        ]);
    }

    /**
     * Hiển thị danh sách lịch hẹn (sắp tới và đã qua) của bệnh nhân đang đăng nhập.
     */
    public function listAppointments()
    {
        // 1. Kiểm tra xác thực và vai trò
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BenhNhan') {
            $this->redirect('/login');
        }

        // 2. Lấy thông tin bệnh nhân từ UserID trong session
        $patientModel = new Patient();
        $patientInfo = $patientModel->findByUserId($_SESSION['user']['UserID']);

        if (!$patientInfo) {
            die("Lỗi: Không tìm thấy hồ sơ bệnh nhân.");
        }

        // 3. Lấy danh sách lịch hẹn của bệnh nhân đó
        $appointmentModel = new Appointment();
        $appointments = $appointmentModel->findAllByPatientIdWithDoctor($patientInfo['BenhNhanID']);

        // 4. Render view và truyền dữ liệu
        $this->render('patients/appointments', [
            'title' => 'Lịch hẹn của tôi',
            'appointments' => $appointments
        ]);
    }

}
