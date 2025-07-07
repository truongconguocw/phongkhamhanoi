<div class="card shadow-sm">
    <div class="card-header"><h4 class="mb-0">Thêm Thuốc mới</h4></div>
    <div class="card-body">
        <form action="/admin/medicines" method="POST">
            <div class="mb-3">
                <label for="TenThuoc" class="form-label">Tên Thuốc</label>
                <input type="text" class="form-control" id="TenThuoc" name="TenThuoc" required>
            </div>
            <div class="mb-3">
                <label for="HoatChat" class="form-label">Hoạt chất chính</label>
                <input type="text" class="form-control" id="HoatChat" name="HoatChat">
            </div>
            <div class="mb-3">
                <label for="DonViTinh" class="form-label">Đơn vị tính</label>
                <input type="text" class="form-control" id="DonViTinh" name="DonViTinh" placeholder="Ví dụ: Viên, Vỉ, Hộp, Lọ..." required>
            </div>
            <div class="d-flex justify-content-end">
                <a href="/admin/medicines" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>