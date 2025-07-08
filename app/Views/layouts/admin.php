<?php
// Hàm trợ giúp để kiểm tra và active link sidebar
function is_active(string $path): string {
    $currentPath = $_SERVER['REQUEST_URI'];
    if ($path === '/admin/dashboard') {
        return $currentPath === $path ? 'active' : '';
    }
    return str_starts_with($currentPath, $path) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Trang Quản trị' ?> - Phòng khám Hà Nội</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
            <span class="sidebar-text-full">Quản trị viên</span>
            <span class="sidebar-text-short">AD</span>
            </div>
            <div class="list-group list-group-flush">
                <a href="/admin/dashboard" class="list-group-item list-group-item-action <?= is_active('/admin/dashboard') ?>">
                    <i class="fas fa-tachometer-alt fa-fw me-2"></i><span class="sidebar-text">Bảng điều khiển</span>
                </a>
                <a href="/admin/appointments" class="list-group-item list-group-item-action <?= is_active('/admin/appointments') ?>">
                    <i class="fas fa-calendar-check fa-fw me-2"></i><span class="sidebar-text">Quản lý Lịch hẹn</span>
                </a>
                <a href="/admin/doctors" class="list-group-item list-group-item-action <?= is_active('/admin/doctors') ?>">
                    <i class="fas fa-user-md fa-fw me-2"></i><span class="sidebar-text">Quản lý Bác sĩ</span>
                </a>
                <a href="/admin/schedules" class="list-group-item list-group-item-action <?= is_active('/admin/schedules') ?>">
                    <i class="fas fa-calendar-alt fa-fw me-2"></i><span class="sidebar-text">Quản lý Lịch làm việc</span>
                </a>
                <a href="/admin/patients" class="list-group-item list-group-item-action <?= is_active('/admin/patients') ?>">
                    <i class="fas fa-user-injured fa-fw me-2"></i><span class="sidebar-text">Quản lý Bệnh nhân</span>
                </a>
                <a href="/admin/specialties" class="list-group-item list-group-item-action <?= is_active('/admin/specialties') ?>">
                    <i class="fas fa-stethoscope fa-fw me-2"></i><span class="sidebar-text">Quản lý Chuyên khoa</span>
                </a>
                <a href="/admin/services" class="list-group-item list-group-item-action <?= is_active('/admin/services') ?>">
                    <i class="fas fa-concierge-bell fa-fw me-2"></i><span class="sidebar-text">Quản lý Dịch vụ</span>
                </a>
                <a href="/admin/medicines" class="list-group-item list-group-item-action <?= is_active('/admin/medicines') ?>">
                    <i class="fas fa-pills fa-fw me-2"></i><span class="sidebar-text">Quản lý Thuốc</span>
                </a>
                <a href="/logout" class="list-group-item list-group-item-action">
                    <i class="fas fa-sign-out-alt fa-fw me-2"></i><span class="sidebar-text">Đăng xuất</span>
                </a>
            </div>
            <div class="sidebar-footer">
                <button class="btn" id="sidebarToggle" title="Thu gọn/Mở rộng sidebar">
                    <i class="fas fa-angle-left"></i>
                </button>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <h1 class="page-header"><?= $title ?? 'Dashboard' ?></h1>
            <?= $content ?? '' ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                    document.body.classList.add('sb-sidenav-toggled');
                }
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }
        });
    </script>
</body>
</html>
