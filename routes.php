<?php
// routes.php
// Đây là file định nghĩa các route cho ứng dụng của bạn.
// Bạn có thể thêm các route khác tại đây.

/**
 * @var Core\Router $router
 * Biến $router được truyền vào từ file public/index.php
 */

// Route cho trang chủ (bạn có thể tạo HomeController sau)
$router->get('', 'HomeController@index');
$router->get('doctors', 'HomeController@listDoctors');
// === Routes cho Xác thực (Authentication) ===
$router->get('login', 'AuthController@showLoginForm'); // Hiển thị form đăng nhập
$router->post('login', 'AuthController@login'); // Xử lý đăng nhập
$router->get('logout', 'AuthController@logout'); // Xử lý đăng xuất

// === Routes cho Bác sĩ (Doctor) ===
$router->get('doctor/schedule', 'DoctorController@showSchedule'); // Hiển thị lịch làm việc của bác sĩ
$router->post('doctor/schedule', 'DoctorController@saveSchedule'); // Lưu lịch làm việc của bác sĩ
$router->get('doctor/appointments', 'DoctorController@listAppointments'); // Hiển thị danh sách các lịch hẹn trong ngày của bác sĩ
$router->get('doctor/patients', 'DoctorController@listPatients'); // Hiển thị danh sách bệnh nhân đã từng khám bởi bác sĩ
$router->get('doctor/dashboard', 'DoctorController@dashboard');
$router->get('doctor/patients/{id}/history', 'PatientController@showHistoryForDoctor');

// === Routes Đăng ký người dùng mới ===
$router->get('register', 'AuthController@showRegisterForm'); // Hiển thị form đăng ký người dùng mới
$router->post('register', 'AuthController@register'); // Xử lý đăng ký người dùng mới

// === Routes cho Hồ sơ Bác sĩ (Doctor Profile) ===
$router->get('doctor/profile', 'DoctorController@showProfile'); // Hiển thị thông tin cá nhân của bác sĩ
$router->post('doctor/profile/update', 'DoctorController@updateProfile'); // Cập nhật thông tin cá nhân của bác sĩ

// === Routes cho Quản lý Lịch hẹn (Appointment) ===
$router->get('appointments/{id}', 'AppointmentController@show'); // Hiển thị chi tiết lịch hẹn
$router->post('appointments/{id}/status', 'AppointmentController@updateStatus'); // Cập nhật trạng thái của lịch hẹn

// === Route để xử lý Form Khám Bệnh ===
$router->post('appointments/{id}/process', 'AppointmentController@processEncounter'); 

// === Route để xem Lịch sử khám của Bệnh nhân ===
$router->get('patients/{id}/history', 'PatientController@showHistory'); 

// === Routes cho Bệnh nhân (Patient) ===
$router->get('patient/profile', 'PatientController@showProfile'); // Hiển thị thông tin cá nhân của bệnh nhân
$router->post('patient/profile/update', 'PatientController@updateProfile'); // Cập nhật thông tin cá nhân của bệnh nhân
$router->get('patient/appointments', 'PatientController@listAppointments'); // Hiển thị lịch sử khám bệnh của bệnh nhân

// === Routes cho Thông tin Sức khỏe (Health Profile) ===
$router->get('patient/health-profile', 'HealthProfileController@index'); // Hiển thị thông tin sức khỏe
$router->post('patient/health-profile/update', 'HealthProfileController@update'); // Cập nhật thông tin sức khỏe

// === Routes cho Quản lý Lịch hẹn (Appointment) ===
$router->get('appointments/create/{doctorId}', 'AppointmentController@create'); // Hiển thị form
$router->post('appointments/store', 'AppointmentController@store'); // Lưu lịch hẹn
$router->get('appointments/{id}', 'AppointmentController@show'); // Hiển thị chi tiết lịch hẹn

// === Routes cho khu vực Quản trị (Admin) ===
$router->get('admin/dashboard', 'Admin\AdminController@dashboard');
$router->get('admin/doctors', 'Admin\DoctorController@index');
$router->get('admin/doctors/create', 'Admin\DoctorController@create'); // Route hiển thị form
$router->post('admin/doctors/store', 'Admin\DoctorController@store');  // Route xử lý form
$router->get('admin/doctors/{id}/edit', 'Admin\DoctorController@edit'); 
$router->post('admin/doctors/{id}/update', 'Admin\DoctorController@update'); 
$router->post('admin/doctors/{id}/delete', 'Admin\DoctorController@destroy');
$router->get('admin/patients', 'Admin\PatientController@index'); // Route hiển thị danh sách bệnh nhân
$router->get('admin/patients/{id}', 'Admin\PatientController@show'); // Route hiển thị chi tiết bệnh nhân
$router->get('admin/appointments', 'Admin\AppointmentController@index'); // Route hiển thị danh sách lịch hẹn
$router->post('admin/appointments/{id}/status', 'Admin\AppointmentController@updateStatus'); // Cập nhật trạng thái lịch hẹn
$router->get('admin/schedules', 'Admin\ScheduleController@index'); // Hiển thị trang chọn bác sĩ để quản lý lịch
$router->get('admin/schedules/{id}', 'Admin\ScheduleController@edit'); // Hiển thị form chỉnh sửa lịch làm việc của bác sĩ
$router->post('admin/schedules/{id}', 'Admin\ScheduleController@update'); // Cập nhật lịch làm việc của bác sĩ
// Routes cho Quản lý Chuyên khoa
$router->get('admin/specialties', 'Admin\SpecialtyController@index');
$router->get('admin/specialties/create', 'Admin\SpecialtyController@create');
$router->post('admin/specialties', 'Admin\SpecialtyController@store');
$router->get('admin/specialties/{id}/edit', 'Admin\SpecialtyController@edit');
$router->post('admin/specialties/{id}', 'Admin\SpecialtyController@update');
$router->post('admin/specialties/{id}/delete', 'Admin\SpecialtyController@destroy');
// Routes cho Quản lý Dịch vụ
$router->get('admin/services', 'Admin\ServiceController@index');
$router->get('admin/services/create', 'Admin\ServiceController@create');
$router->post('admin/services', 'Admin\ServiceController@store');
$router->get('admin/services/{id}/edit', 'Admin\ServiceController@edit');
$router->post('admin/services/{id}', 'Admin\ServiceController@update');
$router->post('admin/services/{id}/delete', 'Admin\ServiceController@destroy');
// Routes cho Quản lý Thuốc
$router->get('admin/medicines', 'Admin\MedicineController@index');
$router->get('admin/medicines/create', 'Admin\MedicineController@create');
$router->post('admin/medicines', 'Admin\MedicineController@store');
$router->get('admin/medicines/{id}/edit', 'Admin\MedicineController@edit');
$router->post('admin/medicines/{id}', 'Admin\MedicineController@update');
$router->post('admin/medicines/{id}/delete', 'Admin\MedicineController@destroy');

// === Routes cho Xác thực OTP (One-Time Password) ===
$router->post('send-otp', 'AuthController@sendOtp');