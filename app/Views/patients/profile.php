<?php $title = 'Hồ sơ cá nhân'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Hồ sơ cá nhân</h4>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/patient/profile/update" method="POST">
                        <!-- Thông tin tài khoản (không cho phép chỉnh sửa trực tiếp) -->
                        <h5 class="mb-3">Thông tin tài khoản</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($user['HoTen']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($user['Email']) ?>" readonly>
                            </div>
                        </div>
                         <div class="mb-4">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['SoDienThoai']) ?>" readonly>
                        </div>

                        <hr>

                        <!-- Thông tin cá nhân (cho phép chỉnh sửa) -->
                        <h5 class="mb-3">Thông tin cá nhân</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="NgaySinh" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars($patient['NgaySinh'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="GioiTinh" class="form-label">Giới tính</label>
                                <select class="form-select" id="GioiTinh" name="GioiTinh">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="Nam" <?= ($patient['GioiTinh'] ?? '') == 'Nam' ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?= ($patient['GioiTinh'] ?? '') == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                                    <option value="Khác" <?= ($patient['GioiTinh'] ?? '') == 'Khác' ? 'selected' : '' ?>>Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="DiaChi" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="DiaChi" name="DiaChi" value="<?= htmlspecialchars($patient['DiaChi'] ?? '') ?>" placeholder="Nhập địa chỉ của bạn">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>