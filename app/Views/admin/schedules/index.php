<div class="container-fluid py-3">
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h4 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2"></i>Danh sách các Bác sĩ có lịch làm việc</h4>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">Chọn bác sĩ bên dưới để xem và chỉnh sửa lịch làm việc hàng tuần.</p>
            <div class="row" id="doctor-list">
                <?php foreach ($doctors as $doctor): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="doctor-card card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="doctor-avatar me-3">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-5"><?= htmlspecialchars($doctor['HoTen']) ?></div>
                                        <?php if (!empty($doctor['TenChuyenKhoa'])): ?>
                                            <div class="text-muted small"><?= htmlspecialchars($doctor['TenChuyenKhoa']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-auto text-end">
                                    <a href="/admin/schedules/<?= $doctor['BacSiID'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-calendar-check me-1"></i>Xem & sửa lịch
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($doctors)): ?>
                    <div class="col-12 text-center text-muted py-5">Chưa có bác sĩ nào trong hệ thống.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.doctor-card {
    transition: box-shadow 0.2s, border-color 0.2s;
    border: 1.5px solid #e2e8f0;
    border-radius: 1rem;
    background: #fff;
}
.doctor-card:hover {
    box-shadow: 0 8px 32px rgba(52, 144, 220, 0.12), 0 1.5px 8px rgba(0,0,0,0.04);
    border-color: #3b82f6;
}
.doctor-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.7rem;
    box-shadow: 0 2px 8px rgba(59,130,246,0.08);
}
.card-header {
    background: #fff;
    border-bottom: 1px solid #e2e8f0;
}
.btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
}
</style>

<script>

// Thêm sự kiện click cho từng card bác sĩ
document.querySelectorAll('.doctor-card').forEach(card => {
    card.addEventListener('click', function(e) {
        if (e.target.tagName.toLowerCase() === 'a') return;
        const btn = card.querySelector('a.btn');
        if (btn) btn.click();
    });
});
</script>