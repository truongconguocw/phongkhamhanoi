<a href="/admin/schedules" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left me-2"></i>Chọn bác sĩ khác
</a>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0 fw-bold">
            <i class="fas fa-calendar-alt me-2"></i>
            Lịch làm việc của: <span class="text-primary"><?= htmlspecialchars($doctor['HoTen']) ?></span>
        </h4>
    </div>
    <div class="card-body p-4">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle flex-shrink-0 me-2"></i>
                <div><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle flex-shrink-0 me-2"></i>
                <div><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="info-box mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <span>Chọn các khung giờ bác sĩ có thể làm việc. Lịch này sẽ được lặp lại hàng tuần.</span>
        </div>

        <form action="/admin/schedules/<?= $doctor['BacSiID'] ?>" method="POST">
            <div class="schedule-grid">
                <?php
                $daysOfWeek = [1 => 'Thứ Hai', 2 => 'Thứ Ba', 3 => 'Thứ Tư', 4 => 'Thứ Năm', 5 => 'Thứ Sáu', 6 => 'Thứ Bảy', 0 => 'Chủ Nhật'];
                $dayColors = [1 => '#3b82f6', 2 => '#10b981', 3 => '#f59e0b', 4 => '#ef4444', 5 => '#8b5cf6', 6 => '#06b6d4', 0 => '#f97316'];
                foreach ($daysOfWeek as $dayIndex => $dayName): ?>
                    <div class="day-card">
                        <div class="day-header" style="background-color: <?= $dayColors[$dayIndex] ?>;">
                            <i class="fas fa-calendar-day me-2"></i><?= $dayName ?>
                        </div>
                        <div class="day-body">
                            <div id="slots-for-day-<?= $dayIndex ?>" class="slots-container">
                                <?php if (!empty($schedules[$dayIndex])): ?>
                                    <?php foreach ($schedules[$dayIndex] as $slot): ?>
                                        <div class="time-slot mb-3">
                                            <div class="row g-2 align-items-center">
                                                <div class="col">
                                                    <label class="form-label small">Bắt đầu</label>
                                                    <input type="time" class="form-control" name="schedules[<?= $dayIndex ?>][start][]" value="<?= $slot['GioBatDau'] ?>" required>
                                                </div>
                                                <div class="col-auto pt-4">
                                                    <i class="fas fa-arrow-right text-muted"></i>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label small">Kết thúc</label>
                                                    <input type="time" class="form-control" name="schedules[<?= $dayIndex ?>][end][]" value="<?= $slot['GioKetThuc'] ?>" required>
                                                </div>
                                                <div class="col-auto pt-4">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-slot-btn" title="Xóa khung giờ">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-slot-btn w-100" data-day="<?= $dayIndex ?>">
                                <i class="fas fa-plus me-1"></i>Thêm khung giờ
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="save-section mt-5">
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save me-2"></i>Lưu Lịch làm việc
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Template cho khung giờ mới -->
<template id="time-slot-template">
    <div class="time-slot mb-3">
        <div class="row g-2 align-items-center">
            <div class="col">
                <label class="form-label small">Bắt đầu</label>
                <input type="time" class="form-control" name="schedules[{day}][start][]" required>
            </div>
            <div class="col-auto pt-4">
                <i class="fas fa-arrow-right text-muted"></i>
            </div>
            <div class="col">
                <label class="form-label small">Kết thúc</label>
                <input type="time" class="form-control" name="schedules[{day}][end][]" required>
            </div>
            <div class="col-auto pt-4">
                <button type="button" class="btn btn-sm btn-outline-danger remove-slot-btn" title="Xóa khung giờ">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<style>
/* Card chính */
.card {
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
}
.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.5rem;
    color: #1e293b;
}

/* Info box */
.info-box {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-left: 4px solid #3b82f6;
    padding: 1rem;
    border-radius: 0.5rem;
    color: #1e40af;
    font-size: 0.95rem;
}

/* Schedule grid */
.schedule-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

/* Day cards */
.day-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.day-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Day headers */
.day-header {
    color: #fff;
    font-weight: 600;
    padding: 1rem;
    text-align: center;
    font-size: 0.95rem;
}

/* Day body */
.day-body {
    padding: 1.5rem;
    min-height: 120px;
}

/* Time slots */
.time-slot {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1rem;
    transition: background-color 0.2s;
}
.time-slot:hover {
    background: #f1f5f9;
}

.slots-container {
    min-height: 60px;
}

/* Form elements */
.form-label.small {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 0.25rem;
}

/* Buttons */
.btn-sm {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.add-slot-btn {
    border-style: dashed;
    transition: all 0.2s;
}
.add-slot-btn:hover {
    border-style: solid;
    background: #eff6ff;
    border-color: #3b82f6;
}

/* Save section */
.save-section {
    border-top: 1px solid #e2e8f0;
    padding-top: 1.5rem;
}

.btn-success {
    background: linear-gradient(135deg,rgb(31, 125, 255) 0%,rgb(37, 99, 255) 100%);
    border: none;
    padding: 1rem 2rem;
    font-weight: 600;
    letter-spacing: 0.025em;
}
.btn-success:hover {
    background: linear-gradient(135deg,rgb(18, 81, 255) 0%,rgb(38, 78, 237) 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(21, 153, 255, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .schedule-grid {
        grid-template-columns: 1fr;
    }
    .day-body {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thêm khung giờ mới
    document.querySelectorAll('.add-slot-btn').forEach(button => {
        button.addEventListener('click', function() {
            const dayIndex = this.dataset.day;
            const template = document.getElementById('time-slot-template').innerHTML;
            const newSlotHtml = template.replace(/{day}/g, dayIndex);
            
            const container = document.getElementById('slots-for-day-' + dayIndex);
            container.insertAdjacentHTML('beforeend', newSlotHtml);
            
            // Nổi bật vào input đầu tiên của khung giờ vừa thêm
            const newSlot = container.lastElementChild;
            const firstInput = newSlot.querySelector('input[type="time"]');
            if (firstInput) firstInput.focus();
        });
    });

    // Xóa khung giờ
    document.body.addEventListener('click', function(event) {
        if (event.target.closest('.remove-slot-btn')) {
            const timeSlot = event.target.closest('.time-slot');
            // Hiệu ứng xóa
            timeSlot.style.transition = 'opacity 0.3s, transform 0.3s';
            timeSlot.style.opacity = '0';
            timeSlot.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                timeSlot.remove();
            }, 300);
        }
    });

    // Validation thời gian
    document.body.addEventListener('change', function(event) {
        if (event.target.type === 'time') {
            const timeSlot = event.target.closest('.time-slot');
            if (timeSlot) {
                const startInput = timeSlot.querySelector('input[name*="[start]"]');
                const endInput = timeSlot.querySelector('input[name*="[end]"]');
                
                if (startInput.value && endInput.value) {
                    if (startInput.value >= endInput.value) {
                        endInput.setCustomValidity('Giờ kết thúc phải sau giờ bắt đầu');
                        endInput.reportValidity();
                    } else {
                        endInput.setCustomValidity('');
                    }
                }
            }
        }
    });
});
</script>