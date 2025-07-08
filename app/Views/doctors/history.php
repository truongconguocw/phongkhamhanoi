<?php
$title = 'Lịch sử khám bệnh: ' . htmlspecialchars($patient['HoTen']);

function get_status_badge_class($status) {
    return match ($status) {
        'DaXacNhan' => 'bg-primary',
        'DaHoanThanh' => 'bg-success',
        'DaHuy' => 'bg-danger',
        'ChoXacNhan' => 'bg-warning text-dark',
        default => 'bg-secondary',
    };
}
?>

<style>
    .history-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .patient-info-header {
        background-color: var(--primary);
        color: white;
        border-radius: 12px 12px 0 0;
    }
    .timeline {
        position: relative;
        padding: 1rem 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--accent1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid var(--background);
    }
    .timeline-content {
        margin-left: 60px;
        background-color: #fff;
        padding: 1.25rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
</style>

<div class="card history-card">
    <div class="card-header patient-info-header p-3">
        <h4 class="mb-0">Lịch sử khám bệnh của: <?= htmlspecialchars($patient['HoTen']) ?></h4>
        <span class="small">Ngày sinh: <?= date('d/m/Y', strtotime($patient['NgaySinh'])) ?> | Giới tính: <?= htmlspecialchars($patient['GioiTinh']) ?></span>
    </div>
    <div class="card-body p-4" style="background-color: var(--background);">
        <a href="/doctor/patients" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left me-2"></i>Quay lại danh sách bệnh nhân</a>

        <div class="timeline">
            <?php if (empty($appointments)): ?>
                <p class="text-center text-muted">Bệnh nhân này chưa có lịch sử khám bệnh.</p>
            <?php else: ?>
                <?php foreach ($appointments as $apt): ?>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Ngày khám: <?= date('d/m/Y H:i', strtotime($apt['ThoiGianKham'])) ?></h5>
                                    <p class="mb-1 text-muted">Bác sĩ: <?= htmlspecialchars($apt['TenBacSi']) ?></p>
                                    <span class="badge rounded-pill <?= get_status_badge_class($apt['TrangThai']) ?>"><?= htmlspecialchars($apt['TrangThai']) ?></span>
                                </div>
                                <a href="/appointments/<?= $apt['LichKhamID'] ?>" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                            </div>
                            <hr>
                            <p><strong>Chẩn đoán:</strong> <?= htmlspecialchars($apt['ChuanDoan'] ?: 'Chưa có chẩn đoán') ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>