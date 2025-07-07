<?php

namespace App\Controllers;
use App\Models\Doctor;
use App\Models\WorkSchedule;
use App\Models\Appointment;
use App\Models\Patient;
class DoctorController extends BaseController
{
     /**
     * Hiển thị trang dashboard chính của bác sĩ.
     */
    public function dashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }

        $doctorModel = new Doctor();
        $doctorInfo = $doctorModel->findByUserId($_SESSION['user']['UserID']);
        
        $appointmentModel = new Appointment();
        // Lấy các lịch hẹn cho ngày hôm nay
        $today = date('Y-m-d');
        $appointments = $appointmentModel->getAppointmentsForDoctorByDate($doctorInfo['BacSiID'], $today);

        $this->render('dashboards/doctor', [
            'title' => 'Bảng điều khiển',
            'appointments' => $appointments,
            'user' => $_SESSION['user']
        ], 'doctor_layout');
    }
    /**
     * Hiển thị trang quản lý lịch làm việc của bác sĩ.
     */
    public function showSchedule()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }
        
        $doctorModel = new Doctor();
        $doctorInfo = $doctorModel->findByUserId($_SESSION['user']['UserID']);
        $doctorId = $doctorInfo['BacSiID'];

        $scheduleModel = new WorkSchedule();
        $schedulesFromDb = $scheduleModel->findByDoctorId($doctorId);

        // Sắp xếp lịch vào một mảng có cấu trúc để view dễ xử lý
        $formattedSchedules = [];
        for ($i = 1; $i <= 7; $i++) { // 1 = Thứ 2, ..., 7 = Chủ Nhật
            $dayIndex = ($i == 7) ? 0 : $i; // Trong DB: 0=CN, 1=T2,...
            $formattedSchedules[$dayIndex] = [];
        }

        foreach ($schedulesFromDb as $slot) {
            $formattedSchedules[$slot['NgayTrongTuan']][] = $slot;
        }

        $this->render('doctors/schedule', [
            'title' => 'Quản lý Lịch làm việc',
            'schedules' => $formattedSchedules
        ], 'doctor_layout');
    }
    /**
     * Lưu lịch làm việc từ form.
     */
    public function saveSchedule()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }

        $doctorModel = new Doctor();
        $doctorInfo = $doctorModel->findByUserId($_SESSION['user']['UserID']);
        $doctorId = $doctorInfo['BacSiID'];

        $postedData = $_POST['schedules'] ?? [];
        $newSchedules = [];

        // Chuyển đổi dữ liệu POST thành định dạng chuẩn để lưu
        foreach ($postedData as $day => $slots) {
            if (!empty($slots['start'])) {
                for ($i = 0; $i < count($slots['start']); $i++) {
                    $start = $slots['start'][$i];
                    $end = $slots['end'][$i];
                    if (!empty($start) && !empty($end)) {
                        $newSchedules[] = [
                            'day' => $day,
                            'start' => $start,
                            'end' => $end
                        ];
                    }
                }
            }
        }

        try {
            $scheduleModel = new WorkSchedule();
            $scheduleModel->syncForDoctor($doctorId, $newSchedules);
            $_SESSION['success_message'] = 'Cập nhật lịch làm việc thành công!';
        } catch (\Exception $e) {
            $_SESSION['error_message'] = 'Đã có lỗi xảy ra khi cập nhật lịch.';
        }

        $this->redirect('/doctor/schedule');
    }

    /**
     * Hiển thị danh sách các lịch hẹn trong ngày của bác sĩ.
     */
    public function listAppointments()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }

        $doctorModel = new Doctor();
        $doctorInfo = $doctorModel->findByUserId($_SESSION['user']['UserID']);
        
        $appointmentModel = new Appointment();
        $appointments = $appointmentModel->findByDoctorId($doctorInfo['BacSiID']);

        $this->render('doctors/appointments', [
            'title' => 'Quản lý Lịch hẹn',
            'appointments' => $appointments
        ], 'doctor_layout');
    }

    /**
     * Hiển thị danh sách các bệnh nhân đã từng khám bởi bác sĩ.
     */
    public function listPatients()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }

        $doctorModel = new Doctor();
        $doctorInfo = $doctorModel->findByUserId($_SESSION['user']['UserID']);
        
        $patientModel = new Patient();
        $patients = $patientModel->findByDoctorId($doctorInfo['BacSiID']);

        $this->render('doctors/patients', [
            'title' => 'Danh sách Bệnh nhân',
            'patients' => $patients
        ], 'doctor_layout');
    }

    /**
     * Hiển thị trang hồ sơ bác sĩ.
     */
    public function showProfile()
    {
        // Đảm bảo người dùng đã đăng nhập và là bác sĩ
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }

        $doctorModel = new Doctor();
        $doctorProfile = $doctorModel->findByUserId($_SESSION['user']['UserID']);

        if (!$doctorProfile) {
            // Xử lý trường hợp không tìm thấy hồ sơ bác sĩ
            die('Lỗi: Không tìm thấy hồ sơ bác sĩ tương ứng.');
        }

        $this->render('doctors/profile', [
            'title' => 'Hồ sơ cá nhân',
            'doctor' => $doctorProfile
        ], 'doctor_layout');
    }

    /**
     * Cập nhật thông tin hồ sơ bác sĩ.
     */
    public function updateProfile()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BacSi') {
            $this->redirect('/login');
        }

        // Lấy dữ liệu từ form
        $dataToUpdate = [
            'MoTa' => $_POST['MoTa'] ?? '',
            'KinhNghiem' => $_POST['KinhNghiem'] ?? ''
        ];

        $doctorModel = new Doctor();
        // Lấy BacSiID từ session hoặc truy vấn lại
        $doctorInfo = $doctorModel->findByUserId($_SESSION['user']['UserID']);
        
        if ($doctorInfo) {
            $doctorModel->update($doctorInfo['BacSiID'], $dataToUpdate);
            $_SESSION['success_message'] = 'Cập nhật hồ sơ thành công!';
        } else {
            $_SESSION['error_message'] = 'Không thể cập nhật hồ sơ.';
        }

        $this->redirect('/doctor/profile');
    }
}
