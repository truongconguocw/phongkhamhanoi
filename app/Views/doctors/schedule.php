<?php $title = 'Quản lý Lịch làm việc'; ?>

<style>
    /* Định nghĩa các biến màu */
    :root {
        --primary: #2C3E50;
        --accent1: #3498DB;
        --background: #F4F6F7;
        --text-dark: #34495E;
        --text-light: #ECF0F1;
        --success: #27AE60;
        --danger: #E74C3C;
    }

    /* Card chính */
    .schedule-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        background-color: #fff;
        overflow: hidden;
    }

    .schedule-card .card-header {
        background-color: var(--primary);
        color: var(--text-light);
        border-bottom: none;
        padding: 1.25rem 1.5rem;
    }

    .schedule-card .card-header h4 {
        margin-bottom: 0;
    }

    .schedule-card .card-body {
        padding: 1.5rem;
    }

    /* Khối cho mỗi ngày trong tuần */
    .day-block {
        background-color: var(--background);
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .day-block h5 {
        color: var(--primary);
        font-weight: 700;
        border-bottom: 2px solid var(--accent1);
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Hàng chứa các ô nhập thời gian */
    .time-slot {
        background-color: #fff;
        padding: 0.75rem;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .time-slot input[type="time"] {
        border: 1px solid #ced4da;
        border-radius: 6px;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .time-slot input[type="time"]:focus {
        border-color: var(--accent1);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        outline: 0;
    }

    /* Nút thêm/xóa */
    .add-slot-btn {
        background-color: transparent;
        border: 1px dashed var(--accent1);
        color: var(--accent1);
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .add-slot-btn:hover {
        background-color: var(--accent1);
        color: white;
        border-style: solid;
    }

    .remove-slot-btn {
        background-color: #f8d7da;
        color: var(--danger);
        border: 1px solid #f5c2c7;
        transition: all 0.2s ease;
    }
    .remove-slot-btn:hover {
        background-color: var(--danger);
        color: white;
    }

    /* Nút lưu chính */
    .btn-save-schedule {
        background-color: var(--success);
        border-color: var(--success);
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    .btn-save-schedule:hover {
        background-color: #229954;
        border-color: #229954;
    }
</style>

<div class="card schedule-card">
    <div class="card-header">
        <h4><i class="fas fa-calendar-alt me-2"></i>Đăng ký Lịch làm việc hàng tuần</h4>
    </div>
    <div class="card-body">
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

        <p class="text-muted">Chọn các khung giờ bạn có thể làm việc. Lịch này sẽ được lặp lại hàng tuần và được dùng để bệnh nhân đặt lịch hẹn.</p>
        <hr class="my-4">

        <form action="/doctor/schedule" method="POST">
            <?php
            $daysOfWeek = [
                1 => 'Thứ Hai', 2 => 'Thứ Ba', 3 => 'Thứ Tư',
                4 => 'Thứ Năm', 5 => 'Thứ Sáu', 6 => 'Thứ Bảy', 0 => 'Chủ Nhật'
            ];
            ?>

            <?php foreach ($daysOfWeek as $dayIndex => $dayName): ?>
                <div class="day-block">
                    <h5><?= $dayName ?></h5>
                    <div id="slots-for-day-<?= $dayIndex ?>">
                        <?php if (!empty($schedules[$dayIndex])): ?>
                            <?php foreach ($schedules[$dayIndex] as $slot): ?>
                                <div class="row g-2 mb-2 align-items-center time-slot">
                                    <div class="col">
                                        <label class="form-label small mb-1">Bắt đầu</label>
                                        <input type="time" class="form-control" name="schedules[<?= $dayIndex ?>][start][]" value="<?= date('H:i', strtotime($slot['GioBatDau'])) ?>" required>
                                    </div>
                                    <div class="col-auto align-self-end pb-2">-</div>
                                    <div class="col">
                                        <label class="form-label small mb-1">Kết thúc</label>
                                        <input type="time" class="form-control" name="schedules[<?= $dayIndex ?>][end][]" value="<?= date('H:i', strtotime($slot['GioKetThuc'])) ?>" required>
                                    </div>
                                    <div class="col-auto align-self-end">
                                        <button type="button" class="btn btn-sm remove-slot-btn"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-sm add-slot-btn mt-2" data-day="<?= $dayIndex ?>">
                        <i class="fas fa-plus me-1"></i>Thêm khung giờ
                    </button>
                </div>
            <?php endforeach; ?>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg btn-save-schedule">
                    <i class="fas fa-save me-2"></i>Lưu Lịch làm việc
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Template cho một khung giờ mới (dùng cho JavaScript) -->
<template id="time-slot-template">
    <div class="row g-2 mb-2 align-items-center time-slot">
        <div class="col">
            <label class="form-label small mb-1">Bắt đầu</label>
            <input type="time" class="form-control" name="schedules[{day}][start][]" required>
        </div>
        <div class="col-auto align-self-end pb-2">-</div>
        <div class="col">
            <label class="form-label small mb-1">Kết thúc</label>
            <input type="time" class="form-control" name="schedules[{day}][end][]" required>
        </div>
        <div class="col-auto align-self-end">
            <button type="button" class="btn btn-sm remove-slot-btn"><i class="fas fa-trash"></i></button>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút "Thêm khung giờ"
    document.querySelectorAll('.add-slot-btn').forEach(button => {
        button.addEventListener('click', function() {
            const dayIndex = this.dataset.day;
            const template = document.getElementById('time-slot-template').innerHTML;
            const newSlotHtml = template.replace(/{day}/g, dayIndex);
            
            const container = document.getElementById('slots-for-day-' + dayIndex);
            container.insertAdjacentHTML('beforeend', newSlotHtml);
        });
    });

    // Xử lý nút "Xóa khung giờ" (sử dụng event delegation)
    document.body.addEventListener('click', function(event) {
        if (event.target.closest('.remove-slot-btn')) {
            event.target.closest('.time-slot').remove();
        }
    });
});
</script>
