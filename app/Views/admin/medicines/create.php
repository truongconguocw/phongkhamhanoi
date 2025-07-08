<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pills me-2"></i>Thông tin thuốc</h5>
    </div>
    <div class="card-body p-4">
        <form action="/admin/medicines" method="POST">
            <div class="mb-3">
                <label for="TenThuoc" class="form-label">Tên Thuốc <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenThuoc" name="TenThuoc" required>
            </div>
            <div class="mb-3">
                <label for="HoatChat" class="form-label">Hoạt chất chính</label>
                <input type="text" class="form-control" id="HoatChat" name="HoatChat">
            </div>
            <div class="mb-3">
                <label for="DonViTinh" class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="DonViTinh" name="DonViTinh" placeholder="Ví dụ: Viên, Vỉ, Hộp, Lọ..." required>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="/admin/medicines" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu Thuốc</button>
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