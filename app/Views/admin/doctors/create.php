<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">Thông tin Bác sĩ mới</h5>
    </div>
    <div class="card-body p-4">
        <form action="/admin/doctors/store" method="POST">
            
            <h6 class="text-primary mb-3">I. THÔNG TIN TÀI KHOẢN</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="HoTen" class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="HoTen" name="HoTen" required>
                </div>
                <div class="col-md-6">
                    <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="Email" name="Email" required>
                </div>
                <div class="col-md-6">
                    <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai">
                </div>
                <div class="col-md-6">
                    <label for="MatKhau" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="MatKhau" name="MatKhau" required>
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
                            <option value="<?= $specialty['ChuyenKhoaID'] ?>"><?= htmlspecialchars($specialty['TenChuyenKhoa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="KinhNghiem" class="form-label">Kinh nghiệm</label>
                    <input type="text" class="form-control" id="KinhNghiem" name="KinhNghiem" placeholder="Ví dụ: 5 năm">
                </div>
                <div class="col-12">
                    <label for="MoTa" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="MoTa" name="MoTa" rows="4" placeholder="Giới thiệu ngắn về trình độ, kinh nghiệm làm việc của bác sĩ..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="/admin/doctors" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu Bác sĩ</button>
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