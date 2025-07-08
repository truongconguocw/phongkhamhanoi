<?php $title = 'Chi tiết Lịch hẹn'; ?>

<style>
    :root {
        --primary: #2C3E50;
        --accent1: #3498DB;
        --background: #F4F6F7;
        --text-dark: #34495E;
        --success: #27AE60;
        --danger: #E74C3C;
    }
    .info-box {
        background-color: var(--background);
        border-left: 5px solid var(--accent1);
        padding: 1.5rem;
        border-radius: 8px;
    }
    .info-box h5 {
        color: var(--primary);
        font-weight: 700;
    }
    .form-label {
        font-weight: 500;
    }
    .btn-save-encounter {
        background-color: var(--success);
        border-color: var(--success);
    }
    .btn-save-encounter:hover {
        background-color: #229954;
        border-color: #229954;
    }
</style>

<div class="row g-4">
    <!-- Cột thông tin & khám bệnh -->
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-file-medical-alt me-2"></i>Hồ sơ Khám bệnh</h4>
            </div>
            <div class="card-body p-4">
                <form action="/appointments/<?= $appointment['LichKhamID'] ?>/process" method="POST">
                    <!-- Các trường thông tin khám bệnh -->
                    <div class="mb-3">
                        <label for="trieu_chung" class="form-label">Triệu chứng</label>
                        <textarea class="form-control" id="trieu_chung" name="trieu_chung" rows="3" required><?= htmlspecialchars($appointment['TrieuChung'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="chuan_doan" class="form-label">Chẩn đoán</label>
                        <textarea class="form-control" id="chuan_doan" name="chuan_doan" rows="3" required><?= htmlspecialchars($appointment['ChuanDoan'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phac_do_dieu_tri" class="form-label">Phác đồ điều trị</label>
                        <textarea class="form-control" id="phac_do_dieu_tri" name="phac_do_dieu_tri" rows="2"><?= htmlspecialchars($appointment['PhacDoDieuTri'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ghi_chu_bac_si" class="form-label">Ghi chú / Lời dặn</label>
                        <textarea class="form-control" id="ghi_chu_bac_si" name="ghi_chu_bac_si" rows="2"><?= htmlspecialchars($appointment['GhiChuCuaBacSi'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ngay_tai_kham" class="form-label">Ngày tái khám</label>
                        <input type="date" class="form-control" id="ngay_tai_kham" name="ngay_tai_kham" value="<?= htmlspecialchars($appointment['NgayTaiKham'] ?? '') ?>">
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                         <a href="/doctor/appointments" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại danh sách</a>
                         <button type="submit" class="btn btn-primary btn-lg btn-save-encounter"><i class="fas fa-save me-2"></i>Lưu và Hoàn thành</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cột thông tin bệnh nhân & lịch hẹn -->
    <div class="col-lg-4">
        <div class="info-box mb-4">
            <h5><i class="fas fa-user-injured me-2"></i>Bệnh nhân</h5>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($appointment['TenBenhNhan']) ?></p>
            <p><strong>Giới tính:</strong> <?= htmlspecialchars($appointment['GioiTinh']) ?></p>
            <p><strong>Ngày sinh:</strong> <?= date('d/m/Y', strtotime($appointment['NgaySinh'])) ?></p>
        </div>
        <div class="info-box">
            <h5><i class="fas fa-calendar-check me-2"></i>Lịch hẹn</h5>
            <p><strong>Thời gian:</strong> <?= date('d/m/Y H:i', strtotime($appointment['ThoiGianKham'])) ?></p>
            <p><strong>Lý do khám:</strong> <?= htmlspecialchars($appointment['LyDoKham']) ?></p>
            <p><strong>Trạng thái:</strong> <span class="badge bg-success"><?= htmlspecialchars($appointment['TrangThai']) ?></span></p>
        </div>
    </div>
</div>