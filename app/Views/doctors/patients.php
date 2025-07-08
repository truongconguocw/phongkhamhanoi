<?php $title = 'Danh sách Bệnh nhân'; ?>

<style>
    /* Định nghĩa các biến màu*/
    :root {
        --primary: #2C3E50;
        --accent1: #3498DB;
        --background: #F4F6F7;
        --text-dark: #34495E;
        --text-light: #ECF0F1;
    }

    /* Card chính bao bọc toàn bộ nội dung */
    .patient-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        background-color: #fff;
        overflow: hidden;
    }

    /* Phần header của card, chứa tiêu đề và ô tìm kiếm */
    .patient-card .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .patient-card .card-header h4 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0;
    }

    /* Ô tìm kiếm */
    .search-wrapper {
        min-width: 300px;
    }
    .search-input {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 0.5rem 1rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .search-input:focus {
        border-color: var(--accent1);
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        outline: 0;
    }

    /* Bảng danh sách bệnh nhân */
    .patient-table thead {
        background-color: var(--background);
    }
    .patient-table th {
        font-weight: 500;
        color: var(--text-dark);
        border: none;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
    }
    .patient-table tbody tr {
        border-bottom: 1px solid var(--background);
    }
    .patient-table tbody tr:last-child {
        border-bottom: none;
    }
    .patient-table td {
        vertical-align: middle;
        border: none;
        padding: 1rem 1.5rem;
        color: var(--text-dark);
    }
    .patient-table .patient-name {
        font-weight: 500;
        color: var(--primary);
    }

    /* Nút hành động */
    .btn-action {
        background-color: var(--background);
        color: var(--text-dark);
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-action:hover {
        background-color: var(--accent1);
        color: var(--text-light);
        transform: translateY(-2px);
    }
</style>

<div class="card patient-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-users me-2"></i>Danh sách Bệnh nhân</h4>
        <div class="search-wrapper">
            <input type="text" id="patientSearch" class="form-control search-input" placeholder="Tìm kiếm theo tên hoặc SĐT...">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 patient-table">
                <thead>
                    <tr>
                        <th>Họ và Tên</th>
                        <th>Ngày Sinh</th>
                        <th>Giới Tính</th>
                        <th>Số Điện Thoại</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody">
                    <?php if (empty($patients)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <h5>Bạn chưa có bệnh nhân nào.</h5>
                                <p>Danh sách sẽ được cập nhật khi bạn có lịch khám.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td class="patient-name"><?= htmlspecialchars($patient['HoTen']) ?></td>
                                <td><?= date('d/m/Y', strtotime($patient['NgaySinh'])) ?></td>
                                <td><?= htmlspecialchars($patient['GioiTinh']) ?></td>
                                <td><?= htmlspecialchars($patient['SoDienThoai']) ?></td>
                                <td class="text-center">
                                    <a href="patients/<?= $patient['BenhNhanID'] ?>/history" class="btn-action" title="Xem Lịch sử khám">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="5" class="text-center text-muted py-5">
                            <h5>Không tìm thấy bệnh nhân nào.</h5>
                            <p>Vui lòng thử lại với từ khóa khác.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patientSearch');
    const tableBody = document.getElementById('patientTableBody');
    const allRows = tableBody.querySelectorAll('tr:not(#noResultsRow)');
    const noResultsRow = document.getElementById('noResultsRow');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleRows = 0;

        allRows.forEach(row => {
            // Lấy nội dung từ cột tên (cột 1) và SĐT (cột 4)
            const nameText = row.cells[0].textContent.toLowerCase();
            const phoneText = row.cells[3].textContent.toLowerCase();
            
            // Kiểm tra nếu tên hoặc SĐT chứa từ khóa tìm kiếm
            if (nameText.includes(searchTerm) || phoneText.includes(searchTerm)) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        // Hiển thị hoặc ẩn thông báo
        if (visibleRows === 0 && allRows.length > 0) {
            noResultsRow.style.display = '';
        } else {
            noResultsRow.style.display = 'none';
        }
    });
});
</script>