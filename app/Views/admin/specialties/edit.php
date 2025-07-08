<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">Nội dung</h5>
    </div>
    <div class="card-body p-4">
        <form action="/admin/specialties/<?= $specialty['ChuyenKhoaID'] ?>/update" method="POST">
            <div class="mb-3">
                <label for="TenChuyenKhoa" class="form-label">Tên Chuyên khoa <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenChuyenKhoa" name="TenChuyenKhoa" value="<?= htmlspecialchars($specialty['TenChuyenKhoa']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="MoTa" class="form-label">Mô tả</label>
                <textarea class="form-control" id="MoTa" name="MoTa" rows="4"><?= htmlspecialchars($specialty['MoTa']) ?></textarea>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="/admin/specialties" class="btn btn-secondary me-2">Hủy</a>
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