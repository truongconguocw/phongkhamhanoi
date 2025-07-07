<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Bảng điều khiển Bác sĩ') ?> - Phòng khám Hà Nội</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/doctor_style.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="d-flex flex-column" id="sidebar-wrapper">
            <div>
                <div class="sidebar-heading">
                    <a href="/doctor/dashboard" class="text-decoration-none">
                        <i class="fas fa-clinic-medical fa-fw"></i><span class="sidebar-text ms-2"><strong>PK Hà Nội</strong></span>
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    <?php $current_uri = $_SERVER['REQUEST_URI']; ?>
                    <a href="/doctor/dashboard" class="list-group-item list-group-item-action <?= (str_starts_with($current_uri, '/doctor/dashboard')) ? 'active' : '' ?>"><i class="fas fa-tachometer-alt fa-fw"></i><span class="sidebar-text ms-2">Bảng điều khiển</span></a>
                    <a href="/doctor/appointments" class="list-group-item list-group-item-action <?= (str_starts_with($current_uri, '/doctor/appointments')) ? 'active' : '' ?>"><i class="fas fa-calendar-check fa-fw"></i><span class="sidebar-text ms-2">Lịch hẹn</span></a>
                    <a href="/doctor/schedule" class="list-group-item list-group-item-action <?= (str_starts_with($current_uri, '/doctor/schedule')) ? 'active' : '' ?>"><i class="fas fa-calendar-alt fa-fw"></i><span class="sidebar-text ms-2">Lịch làm việc</span></a>
                    <a href="/doctor/patients" class="list-group-item list-group-item-action <?= (str_starts_with($current_uri, '/doctor/patients')) ? 'active' : '' ?>"><i class="fas fa-user-injured fa-fw"></i><span class="sidebar-text ms-2">Bệnh nhân</span></a>
                </div>
            </div>

            <!-- Khối User và Đăng xuất ở cuối Sidebar -->
            <div class="mt-auto sidebar-user-info">
                <div class="list-group list-group-flush">
                    <a href="/doctor/profile" class="list-group-item list-group-item-action <?= (str_starts_with($current_uri, '/doctor/profile')) ? 'active' : '' ?>">
                        <i class="fas fa-user-circle fa-fw"></i><span class="sidebar-text ms-2"><?= htmlspecialchars($_SESSION['user']['HoTen'] ?? 'Bác sĩ') ?></span>
                    </a>
                    <a href="/logout" class="list-group-item list-group-item-action logout-link">
                        <i class="fas fa-sign-out-alt fa-fw"></i><span class="sidebar-text ms-2">Đăng xuất</span>
                    </a>
                    <a href="#" id="sidebarToggle" class="list-group-item list-group-item-action text-center toggle-button">
                        <i class="fas fa-angle-double-left fa-fw"></i><span class="sidebar-text ms-2">Thu gọn</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <main class="container-fluid">
                <h1 class="h2 mb-4"><?= htmlspecialchars($title ?? '') ?></h1>
                <?= $content ?? '' ?>
            </main>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;
            const icon = sidebarToggle.querySelector('i');

            const setSidebarState = (isToggled) => {
                if (isToggled) {
                    body.classList.add('sb-sidenav-toggled');
                    icon.classList.remove('fa-angle-double-left');
                    icon.classList.add('fa-angle-double-right');
                } else {
                    body.classList.remove('sb-sidenav-toggled');
                    icon.classList.remove('fa-angle-double-right');
                    icon.classList.add('fa-angle-double-left');
                }
            };

            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                const isToggled = !body.classList.contains('sb-sidenav-toggled');
                setSidebarState(isToggled);
                localStorage.setItem('sb|sidebar-toggle', isToggled);
            });

            // Khôi phục trạng thái sidebar khi tải lại trang
            if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                setSidebarState(true);
            }
        });
    </script>
</body>
</html>