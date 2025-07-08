<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;

class AdminController extends BaseController
{
    /**
     * Hiển thị trang dashboard chính của Admin.
     */
    public function dashboard()
    {
        $userModel = new User();
        $patientModel = new Patient();
        $appointmentModel = new Appointment();
        
        $stats = [
            'total_doctors' => $userModel->countByRole('BacSi'),
            'total_patients' => $patientModel->countAll(),
            'pending_appointments' => $appointmentModel->countByStatus('ChoXacNhan'),
            'completed_today' => $appointmentModel->countCompletedToday(),
        ];

        $recentAppointments = $appointmentModel->getRecentAppointments(5);

        // Dữ liệu cho các widget
        $appointmentChartData = $appointmentModel->getAppointmentCountLast7Days();
        $serviceUsageData = $appointmentModel->getTopServiceUsage(5);
        $doctorActivityToday = $appointmentModel->getDoctorActivityToday();

        // Render view với layout riêng của admin
        $this->render('admin/dashboard', [
            'title' => 'Bảng điều khiển',
            'stats' => $stats,
            'recentAppointments' => $recentAppointments,
            'appointmentChartData' => $appointmentChartData,
            'serviceUsageData' => $serviceUsageData,
            'doctorActivityToday' => $doctorActivityToday
        ], 'admin');
    }
}