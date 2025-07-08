<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle flex-shrink-0 me-2"></i>
        <div>
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); // Xóa message sau khi hiển thị ?>
<?php endif; ?>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pills me-2"></i>Danh sách thuốc</h5>
        <a href="/admin/medicines/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Thêm mới</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tên Thuốc</th>
                        <th>Hoạt chất chính</th>
                        <th>Đơn vị tính</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($medicines)): ?>
                        <tr><td colspan="4" class="text-center p-5 text-muted">Chưa có thuốc nào trong danh mục.</td></tr>
                    <?php else: ?>
                        <?php foreach ($medicines as $medicine): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($medicine['TenThuoc']) ?></td>
                                <td><?= htmlspecialchars($medicine['HoatChat']) ?></td>
                                <td><?= htmlspecialchars($medicine['DonViTinh']) ?></td>
                                <td class="text-end">
                                    <a href="/admin/medicines/<?= $medicine['ThuocID'] ?>/edit" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/medicines/<?= $medicine['ThuocID'] ?>/delete" method="POST" class="d-inline">
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="confirmDeleteModal" class="confirm-modal">
    <div class="confirm-backdrop"></div>
    <div class="confirm-container">
        <div class="confirm-icon">
            <i class="fas fa-pills"></i>
        </div>
        <div class="confirm-content">
            <h3>Xác nhận xóa thuốc</h3>
            <p>Bạn có chắc chắn muốn xóa thuốc này? Hành động này không thể hoàn tác và có thể ảnh hưởng đến các đơn thuốc đã kê.</p>
        </div>
        <div class="confirm-actions">
            <button class="btn-cancel" id="cancelDelete">Hủy bỏ</button>
            <button class="btn-confirm" id="confirmDelete">Xóa ngay</button>
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
    .table td, .table th { vertical-align: middle; padding: 1rem 1.5rem; }

    /* --- BUTTONS --- */
    .btn-sm {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* --- MODAL XÁC NHẬN --- */
    .confirm-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .confirm-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }

    .confirm-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .confirm-container {
        position: relative;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 24px;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.8);
        max-width: 420px;
        width: 90%;
        padding: 2.5rem;
        text-align: center;
        transform: scale(0.8) translateY(20px);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .confirm-modal.show .confirm-container {
        transform: scale(1) translateY(0);
    }

    .confirm-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        animation: pulse 2s infinite;
    }

    .confirm-icon::before {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        border-radius: 50%;
        opacity: 0.3;
        z-index: -1;
    }

    .confirm-icon i {
        font-size: 2rem;
        color: white;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .confirm-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        letter-spacing: -0.025em;
    }

    .confirm-content p {
        color: #64748b;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .confirm-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .btn-cancel, .btn-confirm {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 2px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-confirm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.5);
    }

    .btn-confirm:active {
        transform: translateY(0);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const confirmModal = document.getElementById('confirmDeleteModal');
    const cancelBtn = document.getElementById('cancelDelete');
    const confirmBtn = document.getElementById('confirmDelete');
    const backdrop = confirmModal.querySelector('.confirm-backdrop');
    let currentForm = null;

    // Hiển thị modal
    function showModal(form) {
        currentForm = form;
        confirmModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    // Ẩn modal
    function hideModal() {
        confirmModal.classList.remove('show');
        document.body.style.overflow = '';
        currentForm = null;
    }

    // Xử lý click nút xóa
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const form = this.closest('form');
            showModal(form);
        });
    });

    // Xử lý click nút hủy
    cancelBtn.addEventListener('click', hideModal);

    // Xử lý click backdrop
    backdrop.addEventListener('click', hideModal);

    // Xử lý click nút xác nhận
    confirmBtn.addEventListener('click', function() {
        if (currentForm) {
            currentForm.submit();
        }
        hideModal();
    });

    // Xử lý phím ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && confirmModal.classList.contains('show')) {
            hideModal();
        }
    });
});
</script>