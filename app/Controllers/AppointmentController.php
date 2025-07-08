<?php

namespace App\Controllers;

use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\WorkSchedule;

class AppointmentController extends BaseController
{
    /**
     * Hiển thị chi tiết một lịch hẹn.
     * @param int $id ID của lịch hẹn từ URL.
     */
    public function show(int $id)
    {
        $appointmentModel = new Appointment();
        $appointment = $appointmentModel->findDetailsById($id);

        if (!$appointment) {
            die('Không tìm thấy lịch hẹn.');
        }
        $userRole = $_SESSION['user']['VaiTro'] ?? null;

        if ($userRole === 'BacSi') {
            // Nếu là bác sĩ, render view dành cho bác sĩ với layout của bác sĩ
            $this->render('doctors/show', [
                'title' => 'Chi tiết Lịch hẹn',
                'appointment' => $appointment
            ], 'doctor_layout');
        } else {
        // Lấy danh mục thuốc và dịch vụ cho form
        $medicineModel = new Medicine();
        $serviceModel = new Service();
        $prescriptionModel = new Prescription();

        $this->render('appointments/show', [
            'title' => 'Chi tiết Lịch hẹn',
            'appointment' => $appointment,
            'medicines' => $medicineModel->getAll(),
            'services' => $serviceModel->getAllActive(),
            'prescriptions' => $prescriptionModel->findByAppointmentId($id)
        ]);
    }
    }

    /**
     * Cập nhật trạng thái của một lịch hẹn.
     * @param int $id ID của lịch hẹn từ URL.
     */
    public function updateStatus(int $id)
    {
        $newStatus = $_POST['status'] ?? null;
        $validStatuses = ['DaXacNhan', 'DaHuy'];

        if ($newStatus && in_array($newStatus, $validStatuses)) {
            $appointmentModel = new Appointment();
            $appointmentModel->update($id, ['TrangThai' => $newStatus]);
            $_SESSION['success_message'] = 'Cập nhật trạng thái lịch hẹn thành công!';
        } else {
            $_SESSION['error_message'] = 'Trạng thái không hợp lệ.';
        }

        // Chuyển hướng người dùng trở lại trang danh sách lịch hẹn
        $this->redirect('/doctor/appointments');
    }

    /**
     * Xử lý và lưu thông tin từ form khám bệnh.
     * @param int $id ID của lịch hẹn.
     */
    public function processEncounter(int $id)
    {
        //Kiểm tra quyền của bác sĩ

        $db = (\Core\Database::getInstance())->getConnection();
        $db->beginTransaction();

        try {
            // 1. Cập nhật thông tin khám bệnh vào bảng `lichkham`
            $appointmentModel = new Appointment();
            $encounterData = [
                'TrieuChung' => $_POST['trieu_chung'],
                'ChuanDoan' => $_POST['chuan_doan'],
                'PhacDoDieuTri' => $_POST['phac_do_dieu_tri'],
                'GhiChuCuaBacSi' => $_POST['ghi_chu_bac_si'],
                'NgayTaiKham' => !empty($_POST['ngay_tai_kham']) ? $_POST['ngay_tai_kham'] : null,
                'TrangThai' => 'DaHoanThanh' // Cập nhật trạng thái
            ];
            $appointmentModel->update($id, $encounterData);

            // 2. Xử lý đơn thuốc (xóa cũ, thêm mới)
            // Xóa đơn thuốc cũ
            $stmt = $db->prepare("DELETE FROM donthuoc WHERE LichKhamID = ?");
            $stmt->execute([$id]);

            // Thêm thuốc mới từ form
            if (!empty($_POST['thuoc'])) {
                $sql = "INSERT INTO donthuoc (LichKhamID, ThuocID, SoLuong, HuongDanSuDung) VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                foreach ($_POST['thuoc']['id'] as $key => $thuocId) {
                    if (!empty($thuocId)) {
                        $soLuong = $_POST['thuoc']['soluong'][$key];
                        $huongDan = $_POST['thuoc']['huongdan'][$key];
                        $stmt->execute([$id, $thuocId, $soLuong, $huongDan]);
                    }
                }
            }
            $db->commit();
            $_SESSION['success_message'] = 'Đã lưu hồ sơ khám bệnh thành công!';
        } catch (\Exception $e) {
            $db->rollBack();
            $_SESSION['error_message'] = 'Lỗi khi lưu hồ sơ: ' . $e->getMessage();
        }

        $this->redirect('/appointments/' . $id);
    }

    /**
     * Hiển thị form đặt lịch hẹn với một bác sĩ cụ thể.
     * @param int $doctorId
     */
    public function create(int $doctorId)
    {
        // Bắt buộc phải đăng nhập mới được đặt lịch
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BenhNhan') {
            $_SESSION['error_message'] = 'Vui lòng đăng nhập để đặt lịch hẹn.';
            $this->redirect('/login');
        }

        $doctorModel = new Doctor();
        $doctor = $doctorModel->findWithDetails($doctorId);

        if (!$doctor) {
            die('Không tìm thấy bác sĩ.');
        }

        $scheduleModel = new WorkSchedule();
        $schedule = $scheduleModel->findByDoctorId($doctorId);

        $this->render('appointments/create', [
            'title' => 'Đặt lịch hẹn với Bác sĩ ' . $doctor['HoTen'],
            'doctor' => $doctor,
            'schedule' => $schedule
        ]);
    }

    /**
     * Lưu lịch hẹn mới vào CSDL.
     */
    public function store()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'BenhNhan') {
            $this->redirect('/login');
        }

        // Lấy thông tin bệnh nhân từ session
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($_SESSION['user']['UserID']);

        $data = [
            'BacSiID' => $_POST['BacSiID'],
            'BenhNhanID' => $patient['BenhNhanID'],
            'ThoiGianKham' => $_POST['ThoiGianKham'],
            'LyDoKham' => $_POST['LyDoKham'],
            'TrangThai' => 'ChoXacNhan' // Trạng thái mặc định khi bệnh nhân đặt
        ];

        // TODO: Kiểm tra xem thời gian này có hợp lệ và còn trống không

        $appointmentModel = new Appointment();
        $appointmentModel->create($data);

        $_SESSION['success_message'] = 'Đặt lịch hẹn thành công! Vui lòng chờ xác nhận từ phòng khám.';
        $this->redirect('/patient/appointments'); // Chuyển đến trang lịch hẹn của tôi
    }
}
