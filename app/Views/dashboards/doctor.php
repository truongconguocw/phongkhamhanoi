<h2>Chào mừng Bác sĩ, <?= htmlspecialchars($user['HoTen']) ?>!</h2>
<?php
// Hàm trợ đổi trạng thái sang class của Bootstrap
function get_status_badge($status) {
    switch ($status) {
        case 'DaHoanThanh': return 'bg-success';
        case 'DaXacNhan': return 'bg-primary';
        case 'ChoXacNhan': return 'bg-warning text-dark';
        case 'DaHuy': return 'bg-danger';
        default: return 'bg-secondary';
    }
}
?>

<div class="row g-4">
    <!-- Cột chính bên trái -->
    <div class="col-lg-8">
        <!-- Card thống kê nhanh -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white stat-card bg-accent-1 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 fw-bold"><?= $stats['total'] ?></div>
                        <div class="mt-2 stat-icon"><i class="fas fa-calendar-day me-1"></i> Lịch hẹn hôm nay</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white stat-card bg-success-custom h-100">
                    <div class="card-body text-center">
                        <div class="display-4 fw-bold"><?= $stats['completed'] ?></div>
                        <div class="mt-2 stat-icon"><i class="fas fa-check-circle me-1"></i> Đã hoàn thành</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="/doctor/appointments?status=ChoXacNhan" class="text-decoration-none">
                    <div class="card text-white stat-card bg-warning-custom h-100">
                        <div class="card-body text-center">
                            <div class="display-4 fw-bold"><?= $stats['pending_confirmation'] ?></div>
                            <div class="mt-2 stat-icon"><i class="fas fa-hourglass-half me-1"></i> Chờ xác nhận</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Danh sách lịch hẹn hôm nay -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i>Lịch hẹn hôm nay</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-dashboard">
                        <thead>
                            <tr>
                                <th class="ps-3">Thời gian</th>
                                <th>Bệnh nhân</th>
                                <th>Lý do khám</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center pe-3">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($appointments)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-5">Không có lịch hẹn nào hôm nay.</td></tr>
                            <?php else: ?>
                                <?php foreach ($appointments as $apt): ?>
                                    <tr>
                                        <td class="fw-bold ps-3"><?= date('H:i', strtotime($apt['ThoiGianKham'])) ?></td>
                                        <td><?= htmlspecialchars($apt['TenBenhNhan']) ?></td>
                                        <td class="text-muted"><?= htmlspecialchars($apt['LyDoKham']) ?></td>
                                        <td class="text-center"><span class="badge rounded-pill <?= get_status_badge($apt['TrangThai']) ?>"><?= htmlspecialchars($apt['TrangThai']) ?></span></td>
                                        <td class="text-center pe-3">
                                            <a href="#" class="btn btn-action" title="Xem hồ sơ"><i class="fas fa-user-circle"></i></a>
                                            <?php if($apt['TrangThai'] === 'DaXacNhan'): ?>
                                                <a href="#" class="btn btn-action" title="Bắt đầu khám"><i class="fas fa-play-circle"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phụ bên phải -->
    <div class="col-lg-4">
        <!-- Bệnh nhân tiếp theo -->
        <div class="card next-patient-widget mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-clock me-2"></i>Bệnh nhân tiếp theo</h5>
            </div>
            <div class="card-body">
                <?php if ($nextPatient): ?>
                    <div class="text-center">
                        <i class="fas fa-user-circle patient-avatar"></i>
                        <h5 class="mb-1 mt-2 patient-name"><?= htmlspecialchars($nextPatient['TenBenhNhan']) ?></h5>
                        <p class="mb-1"><strong>Giờ hẹn:</strong> <?= date('H:i', strtotime($nextPatient['ThoiGianKham'])) ?></p>
                        <p class="mb-3 text-muted"><strong>Lý do:</strong> <?= htmlspecialchars($nextPatient['LyDoKham']) ?></p>
                    </div>
                    <hr>
                    <div>
                        <h6><i class="fas fa-exclamation-triangle text-danger me-1"></i> Lưu ý quan trọng:</h6>
                        <ul class="list-unstyled text-muted small">
                            <li><span class="text-danger">❗</span> Dị ứng: (cần truy vấn)</li>
                            <li><span class="text-warning">⚠️</span> Bệnh nền: (cần truy vấn)</li>
                        </ul>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="#" class="btn btn-primary">Xem đầy đủ hồ sơ</a>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-0 py-5">Đã hoàn thành tất cả lịch hẹn.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cần xử lý -->
        <div class="card todo-list">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Cần xử lý</h5>
            </div>
            <div class="list-group list-group-flush">
                <?php if($stats['pending_confirmation'] > 0): ?>
                     <a href="/doctor/appointments?status=ChoXacNhan" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Xác nhận lịch hẹn mới
                        <span class="badge bg-danger rounded-pill"><?= $stats['pending_confirmation'] ?></span>
                    </a>
                <?php endif; ?>
                <a href="#" class="list-group-item list-group-item-action">Review kết quả cận lâm sàng</a>
                <a href="#" class="list-group-item list-group-item-action">Hoàn tất hồ sơ khám cũ</a>
                 <?php if($stats['pending_confirmation'] == 0): ?>
                    <div class="list-group-item text-muted text-center">Không có yêu cầu nào.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php // require_once __DIR__ . '/../layouts/footer.php'; ?>