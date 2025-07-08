<div class="row g-4">
    <div class="col-lg-6 col-xl-3">
        <a href="/admin/appointments?status=ChoXacNhan" class="text-decoration-none">
            <div class="card stat-card bg-card-pending h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-label">Lịch hẹn chờ</div>
                        <div class="text-value"><?= $stats['pending_appointments'] ?? 0 ?></div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="card stat-card bg-card-completed h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-label">Khám hôm nay</div>
                    <div class="text-value"><?= $stats['completed_today'] ?? 0 ?></div>
                </div>
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="card stat-card bg-card-doctors h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-label">Tổng số Bác sĩ</div>
                    <div class="text-value"><?= $stats['total_doctors'] ?? 0 ?></div>
                </div>
                <div class="stat-icon"><i class="fas fa-user-md"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="card stat-card bg-card-patients h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-label">Tổng số Bệnh nhân</div>
                    <div class="text-value"><?= $stats['total_patients'] ?? 0 ?></div>
                </div>
                <div class="stat-icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Bảng lịch hẹn gần đây -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Lịch hẹn gần đây</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Bệnh nhân</th>
                                <th>Bác sĩ</th>
                                <th>Thời gian khám</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentAppointments)): ?>
                                <tr><td colspan="4" class="text-center p-4 text-muted">Không có lịch hẹn nào.</td></tr>
                            <?php else: ?>
                                <?php
                                // Hàm chuyển đổi trạng thái
                                function format_status_text($status) {
                                    $map = [
                                        'DaXacNhan' => 'Đã Xác Nhận',
                                        'DaHoanThanh' => 'Đã Hoàn Thành',
                                        'DaHuy' => 'Đã Hủy',
                                        'ChoXacNhan' => 'Chờ Xác Nhận'
                                    ];
                                    return $map[$status] ?? $status;
                                }
                                ?>
                                <?php foreach ($recentAppointments as $apt): ?>
                                    <?php
                                    // Logic để chọn class cho badge trạng thái (sửa lại chuỗi so sánh)
                                    $status = $apt['TrangThai'];
                                    $status_class = 'status-default'; // Mặc định
                                    if ($status === 'DaXacNhan') $status_class = 'status-confirmed';
                                    elseif ($status === 'DaHoanThanh') $status_class = 'status-completed';
                                    elseif ($status === 'DaHuy') $status_class = 'status-cancelled';
                                    elseif ($status === 'ChoXacNhan') $status_class = 'status-pending';
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($apt['TenBenhNhan']) ?></td>
                                        <td><?= htmlspecialchars($apt['TenBacSi']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($apt['ThoiGianKham'])) ?></td>
                                        <td><span class="badge rounded-pill <?= $status_class ?>"><?= htmlspecialchars(format_status_text($status)) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hàng chứa các widget -->
<div class="row mt-4 g-4">
    <!-- Widget Biểu đồ Lịch hẹn -->
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2"></i>Lịch hẹn 7 ngày qua</h5>
            </div>
            <div class="card-body">
                <canvas id="appointmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Widget Hoạt động Bác sĩ -->
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-user-md me-2"></i>Hoạt động Bác sĩ Hôm nay</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if (empty($doctorActivityToday)): ?>
                        <li class="list-group-item text-muted">Không có bác sĩ nào hoạt động hôm nay.</li>
                    <?php else: ?>
                        <?php foreach ($doctorActivityToday as $activity): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($activity['TenBacSi']) ?>
                                <span class="badge bg-primary rounded-pill"><?= $activity['SoLichHen'] ?> ca</span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Widget Biểu đồ Dịch vụ -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2"></i>Tỉ lệ Dịch vụ được sử dụng</h5>
            </div>
            <div class="card-body d-flex justify-content-center p-4">
                <div style="max-width: 400px; width: 100%;">
                    <canvas id="serviceUsageChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- Thư viện Chart.js và script khởi tạo -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Dữ liệu biểu đồ lịch hẹn (chuyển từ PHP sang JS)
    const appointmentData = <?= json_encode($appointmentChartData ?? []) ?>;
    const appointmentLabels = appointmentData.map(item => new Date(item.appointment_date).toLocaleDateString('vi-VN'));
    const appointmentCounts = appointmentData.map(item => item.appointment_count);

    // 2. Dữ liệu biểu đồ dịch vụ
    const serviceData = <?= json_encode($serviceUsageData ?? []) ?>;
    const serviceLabels = serviceData.map(item => item.TenDichVu);
    const serviceCounts = serviceData.map(item => item.usage_count);

    // Khởi tạo biểu đồ Lịch hẹn
    const ctxAppointment = document.getElementById('appointmentChart');
    if (ctxAppointment && appointmentData.length > 0) {
        new Chart(ctxAppointment, {
            type: 'bar',
            data: {
                labels: appointmentLabels,
                datasets: [{
                    label: 'Số lịch hẹn',
                    data: appointmentCounts,
                    backgroundColor: 'rgba(52, 152, 219, 0.7)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    // Khởi tạo biểu đồ Dịch vụ
    const ctxService = document.getElementById('serviceUsageChart');
    if (ctxService && serviceData.length > 0) {
        new Chart(ctxService, {
            type: 'doughnut',
            data: {
                labels: serviceLabels,
                datasets: [{
                    label: 'Số lần sử dụng',
                    data: serviceCounts,
                    backgroundColor: [
                        '#3498DB', '#2ECC71', '#F1C40F', '#E67E22', '#9B59B6',
                        '#34495E', '#1ABC9C', '#E74C3C'
                    ],
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
    }
});
</script>