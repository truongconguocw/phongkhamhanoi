<?php
// require_once __DIR__ . '/../layouts/header.php'; ?>

<h1>Chào mừng Bác sĩ, <?= htmlspecialchars($user['HoTen']) ?>!</h1>
<p>Đây là bảng điều khiển của bạn.</p>
<ul>
    <li><a href="/doctor/schedule">Xem lịch làm việc</a></li>
    <li><a href="/doctor/appointments">Xem lịch hẹn hôm nay</a></li>
    <li><a href="/logout">Đăng xuất</a></li>
</ul>

<?php // require_once __DIR__ . '/../layouts/footer.php'; ?>