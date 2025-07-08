<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="/admin/patients" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm bệnh nhân theo tên, SĐT, email..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
</div>

<!-- Card Bảng dữ liệu -->
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-users me-2"></i>Danh sách Bệnh nhân</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Thông tin Bệnh nhân</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Ngày tạo hồ sơ</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($patients)): ?>
                        <tr>
                            <td colspan="5" class="text-center p-5 text-muted">Không tìm thấy bệnh nhân nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($patient['HoTen']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($patient['SoDienThoai']) ?></div>
                                </td>
                                <td><?= $patient['NgaySinh'] ? date('d/m/Y', strtotime($patient['NgaySinh'])) : 'N/A' ?></td>
                                <td><?= htmlspecialchars($patient['GioiTinh'] ?? 'N/A') ?></td>
                                <td><?= date('d/m/Y', strtotime($patient['NgayTaoHoSo'])) ?></td>
                                <td class="text-end">
                                    <a href="/admin/patients/<?= $patient['BenhNhanID'] ?>" class="btn btn-sm btn-outline-primary" title="Xem chi tiết và lịch sử khám">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* --- CARD CHUNG --- */
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

    /* --- TABLE STYLES --- */
    .table-responsive { border-radius: 0 0 0.75rem 0.75rem; overflow: hidden; }
    .table thead th {
        font-weight: 600;
        color: #34495E;
        background-color: #F8F9FA;
        border: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table tbody tr:hover { background-color: #f1f5f9; }
    .table td, .table th { vertical-align: middle; padding: 1rem; }

    /* --- BUTTONS --- */
    .btn-sm {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>