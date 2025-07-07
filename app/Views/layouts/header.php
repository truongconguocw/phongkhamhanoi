<?php
/**
 * 
 * @package App\Views\Layouts
 */
?>
<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-clinic-medical"></i> Phòng khám Hà Nội
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/doctors">Đội ngũ Bác sĩ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/services">Dịch vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php
                    if (isset($_SESSION['user'])): ?>
                        <div class="dropdown">
                            <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i>
                                <?= htmlspecialchars($_SESSION['user']['HoTen']) ?>
                            </a>
                            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser">
                                <li><a class="dropdown-item" href="/patient/profile">Hồ sơ của tôi</a></li>
                                <li><a class="dropdown-item" href="/patient/health-profile">Thông tin sức khỏe</a></li>
                                <li><a class="dropdown-item" href="/patient/appointments">Lịch hẹn của tôi</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="/appointments/create" class="btn btn-warning me-2">
                            <i class="fas fa-calendar-check me-1"></i> Đặt lịch hẹn
                        </a>
                        <a href="/login" class="btn btn-outline-light">Đăng nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>
