<?php $title = 'Hồ sơ cá nhân'; ?>

<style>
    :root {
        --primary: #2C3E50;
        --accent1: #3498DB;
        --background: #F4F6F7;
        --text-dark: #34495E;
        --success: #27AE60;
    }

    .profile-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        background-color: #fff;
        overflow: hidden;
    }

    .profile-card .card-header {
        background-color: var(--primary);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .profile-card .card-header h4 {
        margin-bottom: 0;
    }

    .profile-card .card-body {
        padding: 2rem;
    }

    .profile-card .form-label {
        font-weight: 500;
        color: var(--text-dark);
    }

    .profile-card .form-control[readonly] {
        background-color: var(--background);
        cursor: not-allowed;
    }

    .profile-card .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
    }

    .profile-card .form-control:focus {
        border-color: var(--accent1);
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .profile-card hr {
        margin: 2rem 0;
    }

    .profile-card .btn-save {
        background-color: var(--success);
        border-color: var(--success);
        font-weight: 500;
        padding: 0.75rem;
        transition: all 0.2s ease;
    }

    .profile-card .btn-save:hover {
        background-color: #229954;
        border-color: #229954;
        transform: translateY(-2px);
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
        <div class="card profile-card">
            <div class="card-header">
                <h4><i class="fas fa-id-card me-2"></i>Hồ sơ cá nhân & Chuyên môn</h4>
            </div>
            <div class="card-body">

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <form action="/doctor/profile/update" method="POST">
                    <!-- Thông tin cơ bản (không cho phép chỉnh sửa) -->
                    <h5 class="mb-3 text-primary">Thông tin cơ bản</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($doctor['HoTen']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($doctor['Email']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($doctor['SoDienThoai']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chuyên khoa</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($doctor['TenChuyenKhoa'] ?? 'Chưa cập nhật') ?>" readonly>
                        </div>
                    </div>

                    <hr>

                    <!-- Thông tin chuyên môn (cho phép chỉnh sửa) -->
                    <h5 class="mb-3 text-primary">Thông tin chuyên môn</h5>
                    <div class="mb-3">
                        <label for="KinhNghiem" class="form-label">Kinh nghiệm</label>
                        <input type="text" class="form-control" id="KinhNghiem" name="KinhNghiem" value="<?= htmlspecialchars($doctor['KinhNghiem'] ?? '') ?>" placeholder="Ví dụ: 10 năm kinh nghiệm trong lĩnh vực Tim mạch">
                    </div>
                    <div class="mb-4">
                        <label for="MoTa" class="form-label">Mô tả bản thân</label>
                        <textarea class="form-control" id="MoTa" name="MoTa" rows="5" placeholder="Mô tả về quá trình học tập, công tác, các thành tựu đã đạt được..."><?= htmlspecialchars($doctor['MoTa'] ?? '') ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg btn-save">
                            <i class="fas fa-save me-2"></i>Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
