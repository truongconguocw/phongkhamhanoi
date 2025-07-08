<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">Chỉnh sửa thông tin Bác sĩ</h5>
    </div>
    <div class="card-body p-4">
        <form action="/admin/doctors/<?= $doctor['BacSiID'] ?>/update" method="POST">
            
            <h6 class="text-primary mb-3">I. THÔNG TIN TÀI KHOẢN</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="HoTen" class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?= htmlspecialchars($user['HoTen'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($user['Email'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai" value="<?= htmlspecialchars($user['SoDienThoai'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label for="MatKhau" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="MatKhau" name="MatKhau" placeholder="Để trống nếu không đổi">
                    <div class="form-text">Chỉ nhập nếu bạn muốn thay đổi mật khẩu.</div>
                </div>
            </div>

            <hr class="my-4">

            <h6 class="text-primary mb-3">II. THÔNG TIN CHUYÊN MÔN</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="ChuyenKhoaID" class="form-label">Chuyên khoa</label>
                    <select class="form-select" id="ChuyenKhoaID" name="ChuyenKhoaID">
                        <option value="">-- Chọn chuyên khoa --</option>
                        <?php foreach ($specialties as $specialty): ?>
                            <option value="<?= $specialty['ChuyenKhoaID'] ?>" <?= ($doctor['ChuyenKhoaID'] ?? '') == $specialty['ChuyenKhoaID'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($specialty['TenChuyenKhoa']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="KinhNghiem" class="form-label">Kinh nghiệm</label>
                    <input type="text" class="form-control" id="KinhNghiem" name="KinhNghiem" placeholder="Ví dụ: 5 năm" value="<?= htmlspecialchars($doctor['KinhNghiem'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label for="MoTa" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="MoTa" name="MoTa" rows="4" placeholder="Giới thiệu ngắn về trình độ, kinh nghiệm làm việc của bác sĩ..."><?= htmlspecialchars($doctor['MoTa'] ?? '') ?></textarea>
                </div>
                 <div class="col-12">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="HoatDong" id="hoatdong_1" value="1" <?= ($user['HoatDong'] ?? 1) == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="hoatdong_1">
                            Hoạt động
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="HoatDong" id="hoatdong_0" value="0" <?= ($user['HoatDong'] ?? 1) == 0 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="hoatdong_0">
                            Vô hiệu hóa
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="/admin/doctors" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<style>
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
    .form-label {
        font-weight: 500;
    }
</style>