<?php
// Hàm chuyển đổi trạng thái từ CSDL sang dạng văn bản có dấu
function format_status_text($status) {
    $map = [
        'DaXacNhan' => 'Đã Xác Nhận',
        'DaHoanThanh' => 'Đã Hoàn Thành',
        'DaHuy' => 'Đã Hủy',
        'ChoXacNhan' => 'Chờ Xác Nhận'
    ];
    return $map[$status] ?? $status;
}

// Hàm gán class CSS cho từng trạng thái
function get_status_class($status) {
    $map = [
        'DaXacNhan' => 'status-confirmed',
        'DaHoanThanh' => 'status-completed',
        'DaHuy' => 'status-cancelled',
        'ChoXacNhan' => 'status-pending'
    ];
    return $map[$status] ?? 'status-default';
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="/admin/patients" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="row">
    <!-- Cột thông tin cá nhân -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2"></i>Thông tin Bệnh nhân</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0"><strong>Họ tên:</strong> <span><?= htmlspecialchars($patient['HoTen']) ?></span></li>
                    <li class="list-group-item d-flex justify-content-between px-0"><strong>Ngày sinh:</strong> <span><?= $patient['NgaySinh'] ? date('d/m/Y', strtotime($patient['NgaySinh'])) : 'N/A' ?></span></li>
                    <li class="list-group-item d-flex justify-content-between px-0"><strong>Giới tính:</strong> <span><?= htmlspecialchars($patient['GioiTinh'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item d-flex justify-content-between px-0"><strong>Điện thoại:</strong> <span><?= htmlspecialchars($patient['SoDienThoai']) ?></span></li>
                    <li class="list-group-item d-flex justify-content-between px-0"><strong>Email:</strong> <span><?= htmlspecialchars($patient['Email'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item px-0"><strong>Địa chỉ:</strong> <div class="text-muted mt-1"><?= htmlspecialchars($patient['DiaChi'] ?? 'Chưa cập nhật') ?></div></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Cột lịch sử khám -->
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Lịch sử Khám bệnh</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($appointments)): ?>
                    <div class="p-5 text-center text-muted">Bệnh nhân này chưa có lịch sử khám bệnh.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Ngày khám</th>
                                    <th>Bác sĩ</th>
                                    <th>Lý do</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $apt): ?>
                                    <tr>
                                        <td><?= date('d/m/Y H:i', strtotime($apt['ThoiGianKham'])) ?></td>
                                        <td><?= htmlspecialchars($apt['TenBacSi']) ?></td>
                                        <td><?= htmlspecialchars($apt['LyDoKham']) ?></td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill <?= get_status_class($apt['TrangThai']) ?>">
                                                <?= htmlspecialchars(format_status_text($apt['TrangThai'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- CARD CHUNG --- */
    .card {
        border: 1px solid #EAECEE;
        border-radius: 0.75rem;
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #EAECEE;
        padding: 1rem 1.5rem;
        color: #2C3E50;
    }
    .list-group-item {
        background-color: transparent;
    }

    /* --- TABLE STYLES --- */
    .table-responsive { border-radius: 0 0 0.75rem 0.75rem; overflow: hidden; }
    .table thead th {
        font-weight: 600;
        color: #34495E;
        background-color: #F8F9FA;
        border: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table tbody tr:hover { background-color: #f1f5f9; }
    .table td, .table th { vertical-align: middle; padding: 1rem; }

    /* --- STATUS BADGES --- */
    .badge { padding: 0.4em 0.8em; font-size: 0.75rem; font-weight: 600; }
    .status-confirmed { background-color: #e8f4fd !important; color: #3498db !important; }
    .status-completed { background-color: #eaf7ec !important; color: #27ae60 !important; }
    .status-cancelled { background-color: #fbebeb !important; color: #e74c3c !important; }
    .status-pending { background-color: #fef8e5 !important; color: #f39c12 !important; }
    .status-default { background-color: #f4f6f7 !important; color: #7f8c8d !important; }
</style>