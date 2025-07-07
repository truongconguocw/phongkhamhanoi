<?php $title = 'Đặt lịch hẹn'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đặt lịch hẹn với Bác sĩ <?= htmlspecialchars($doctor['HoTen']) ?></h4>
                </div>
                <div class="card-body p-4">
                    <p><strong>Chuyên khoa:</strong> <?= htmlspecialchars($doctor['TenChuyenKhoa'] ?? 'Chưa cập nhật') ?></p>
                    <p>Vui lòng chọn ngày và giờ khám phù hợp từ lịch làm việc của bác sĩ dưới đây.</p>
                    <hr>

                    <form action="/appointments/store" method="POST">
                        <input type="hidden" name="BacSiID" value="<?= $doctor['BacSiID'] ?>">

                        <div class="mb-3">
                            <label for="ThoiGianKham" class="form-label fw-bold">Chọn thời gian khám</label>
                            <input type="datetime-local" class="form-control" id="ThoiGianKham" name="ThoiGianKham" required>
                            <div class="form-text">
                                Bác sĩ làm việc vào các ngày: 
                                <?php 
                                $daysOfWeek = [1 => 'T2', 2 => 'T3', 3 => 'T4', 4 => 'T5', 5 => 'T6', 6 => 'T7', 0 => 'CN'];
                                $workDays = array_unique(array_column($schedule, 'NgayTrongTuan'));
                                foreach($workDays as $day) echo $daysOfWeek[$day] . ' ';
                                ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LyDoKham" class="form-label fw-bold">Lý do/Triệu chứng khám</label>
                            <textarea class="form-control" id="LyDoKham" name="LyDoKham" rows="4" placeholder="Vui lòng mô tả ngắn gọn triệu chứng của bạn..." required></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Xác nhận Đặt lịch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>