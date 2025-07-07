<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Patient;
use App\Models\Appointment;

class PatientController extends BaseController
{
    public function __construct()
    {
        // Middleware: Chỉ Admin mới có quyền truy cập
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'QuanTri') {
            $this->redirect('/login');
        }
    }

    /**
     * Hiển thị danh sách tất cả bệnh nhân, hỗ trợ tìm kiếm.
     */
    public function index()
    {
        $patientModel = new Patient();
        $searchTerm = $_GET['search'] ?? '';
        $patients = $patientModel->getAllPatientsForAdmin($searchTerm);

        $this->render('admin/patients/index', [
            'title' => 'Quản lý Bệnh nhân',
            'patients' => $patients,
            'searchTerm' => $searchTerm
        ], 'admin');
    }

    /**
     * Hiển thị chi tiết hồ sơ và lịch sử khám của một bệnh nhân.
     * @param int $id ID của bệnh nhân.
     */
    public function show(int $id)
    {
        $patientModel = new Patient();
        $patient = $patientModel->findPatientDetails($id);

        if (!$patient) {
            die('Không tìm thấy bệnh nhân.');
        }

        $appointmentModel = new Appointment();
        $appointments = $appointmentModel->findAllByPatientIdWithDoctor($id);

        $this->render('admin/patients/show', [
            'title' => 'Hồ sơ Bệnh nhân: ' . htmlspecialchars($patient['HoTen']),
            'patient' => $patient,
            'appointments' => $appointments
        ], 'admin');
    }
}