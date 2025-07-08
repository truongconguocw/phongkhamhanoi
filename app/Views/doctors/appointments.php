<?php
$title = 'Quản lý Lịch hẹn';

// Hàm lấy class màu cho badge trạng thái
function get_status_badge_class($status) {
    return match ($status) {
        'DaXacNhan' => 'bg-primary',
        'DaHoanThanh' => 'bg-success',
        'DaHuy' => 'bg-danger',
        'ChoXacNhan' => 'bg-warning text-dark',
        default => 'bg-secondary',
    };
}

// Lấy trạng thái đang lọc từ URL để active nút filter
$currentStatus = $_GET['status'] ?? 'all';
?>

<style>
    :root {
        --primary: #2C3E50;
        --accent1: #3498DB;
        --background: #F4F6F7;
        --text-dark: #34495E;
        --success: #27AE60;
        --danger: #E74C3C;
        --warning: #F39C12;
    }

    .appointment-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        background-color: #fff;
        overflow: hidden;
    }

    .appointment-card .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .appointment-card .card-header h4 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0;
    }

    /* Thanh filter */
    .filter-nav .btn {
        border-radius: 20px;
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
        background-color: var(--background);
        color: var(--text-dark);
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .filter-nav .btn:hover {
        background-color: #e2e6ea;
    }
    .filter-nav .btn.active {
        background-color: var(--accent1);
        color: white;
        border-color: var(--accent1);
        box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
    }

    /* Bảng */
    .appointment-table thead { background-color: var(--background); }
    .appointment-table th {
        font-weight: 500;
        color: var(--text-dark);
        border: none;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
    }
    .appointment-table tbody tr { border-bottom: 1px solid var(--background); }
    .appointment-table tbody tr:last-child { border-bottom: none; }
    .appointment-table td {
        vertical-align: middle;
        border: none;
        padding: 1rem 1.5rem;
    }

    /* Nút hành động */
    .btn-action {
        background-color: var(--background);
        color: var(--text-dark);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-action.confirm:hover { background-color: var(--success); color: white; }
    .btn-action.cancel:hover { background-color: var(--danger); color: white; }
    .btn-action.view:hover { background-color: var(--accent1); color: white; }
</style>

<div class="card appointment-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Quản lý Lịch hẹn</h4>
        <div class="filter-nav btn-group" role="group">
            <a href="/doctor/appointments" class="btn <?= $currentStatus == 'all' ? 'active' : '' ?>">Tất cả</a>
            <a href="/doctor/appointments?status=ChoXacNhan" class="btn <?= $currentStatus == 'ChoXacNhan' ? 'active' : '' ?>">Chờ xác nhận</a>
            <a href="/doctor/appointments?status=DaXacNhan" class="btn <?= $currentStatus == 'DaXacNhan' ? 'active' : '' ?>">Đã xác nhận</a>
            <a href="/doctor/appointments?status=DaHoanThanh" class="btn <?= $currentStatus == 'DaHoanThanh' ? 'active' : '' ?>">Hoàn thành</a>
            <a href="/doctor/appointments?status=DaHuy" class="btn <?= $currentStatus == 'DaHuy' ? 'active' : '' ?>">Đã hủy</a>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success m-3" role="alert">
                <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 appointment-table">
                <thead>
                    <tr>
                        <th>Bệnh nhân</th>
                        <th>Thời gian khám</th>
                        <th>Lý do khám</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($appointments)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <h5>Không có lịch hẹn nào.</h5>
                                <p>Không có lịch hẹn nào phù hợp với bộ lọc hiện tại.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($appointments as $apt): ?>
                            <tr>
                                <td><?= htmlspecialchars($apt['TenBenhNhan']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($apt['ThoiGianKham'])) ?></td>
                                <td class="text-muted"><?= htmlspecialchars($apt['LyDoKham']) ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill <?= get_status_badge_class($apt['TrangThai']) ?>">
                                        <?= htmlspecialchars($apt['TrangThai']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="/appointments/<?= $apt['LichKhamID'] ?>" class="btn-action view" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                                    <?php if ($apt['TrangThai'] == 'ChoXacNhan'): ?>
                                        <form action="/appointments/<?= $apt['LichKhamID'] ?>/status" method="POST" class="d-inline">
                                            <input type="hidden" name="status" value="DaXacNhan">
                                            <button type="submit" class="btn-action confirm" title="Xác nhận"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="/appointments/<?= $apt['LichKhamID'] ?>/status" method="POST" class="d-inline">
                                            <input type="hidden" name="status" value="DaHuy">
                                            <button type="submit" class="btn-action cancel" title="Hủy"><i class="fas fa-times"></i></button>
                                        </form>
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