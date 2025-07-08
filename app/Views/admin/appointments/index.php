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

<!-- Card Bộ lọc -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Bộ lọc Lịch hẹn</h5>
    </div>
    <div class="card-body">
        <form action="/admin/appointments" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-6 col-lg-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="ChoXacNhan" <?= ($filters['status'] ?? '') == 'ChoXacNhan' ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="DaXacNhan" <?= ($filters['status'] ?? '') == 'DaXacNhan' ? 'selected' : '' ?>>Đã xác nhận</option>
                        <option value="DaHoanThanh" <?= ($filters['status'] ?? '') == 'DaHoanThanh' ? 'selected' : '' ?>>Đã hoàn thành</option>
                        <option value="DaHuy" <?= ($filters['status'] ?? '') == 'DaHuy' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label for="doctor_id" class="form-label">Bác sĩ</label>
                    <select name="doctor_id" id="doctor_id" class="form-select">
                        <option value="">Tất cả</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['BacSiID'] ?>" <?= ($filters['doctor_id'] ?? '') == $doctor['BacSiID'] ? 'selected' : '' ?>><?= htmlspecialchars($doctor['HoTen']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label for="date" class="form-label">Ngày khám</label>
                    <input type="date" name="date" id="date" class="form-control" value="<?= htmlspecialchars($filters['date'] ?? '') ?>">
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i> Lọc</button>
                        <a href="/admin/appointments" class="btn btn-outline-secondary">Xóa bộ lọc</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Card Bảng dữ liệu -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Bệnh nhân</th>
                        <th>Bác sĩ</th>
                        <th>Thời gian khám</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($appointments)): ?>
                        <tr><td colspan="5" class="text-center p-5 text-muted">Không có lịch hẹn nào phù hợp.</td></tr>
                    <?php else: ?>
                        <?php foreach ($appointments as $apt): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($apt['TenBenhNhan']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($apt['SoDienThoaiBenhNhan']) ?></div>
                                </td>
                                <td><?= htmlspecialchars($apt['TenBacSi']) ?></td>
                                <td><?= date('H:i - d/m/Y', strtotime($apt['ThoiGianKham'])) ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill <?= get_status_class($apt['TrangThai']) ?>">
                                        <?= htmlspecialchars(format_status_text($apt['TrangThai'])) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <?php if ($apt['TrangThai'] == 'ChoXacNhan'): ?>
                                        <form action="/admin/appointments/<?= $apt['LichKhamID'] ?>/status" method="POST" class="d-inline me-1">
                                            <input type="hidden" name="status" value="DaXacNhan">
                                            <button type="submit" class="btn btn-sm btn-success" title="Xác nhận"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="/admin/appointments/<?= $apt['LichKhamID'] ?>/status" method="POST" class="d-inline">
                                            <input type="hidden" name="status" value="DaHuy">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hủy" onclick="return confirm('Bạn chắc chắn muốn hủy lịch hẹn này?')"><i class="fas fa-times"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-sm btn-outline-secondary" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
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

    /* --- BUTTONS --- */
    .btn-sm {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>