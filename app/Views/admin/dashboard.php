<div class="row">
    <div class="col-md-6 col-xl-3 mb-4">
        <a href="/admin/appointments?status=ChoXacNhan" class="text-decoration-none">
            <div class="card shadow border-start-primary py-2 h-100">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Lịch hẹn chờ</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span><?= $stats['pending_appointments'] ?></span></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-success py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Khám hôm nay</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span><?= $stats['completed_today'] ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-info py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Tổng số Bác sĩ</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span><?= $stats['total_doctors'] ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-md fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-warning py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Tổng số Bệnh nhân</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span><?= $stats['total_patients'] ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Lịch hẹn gần đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bệnh nhân</th>
                                <th>Bác sĩ</th>
                                <th>Thời gian khám</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentAppointments as $apt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($apt['TenBenhNhan']) ?></td>
                                    <td><?= htmlspecialchars($apt['TenBacSi']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($apt['ThoiGianKham'])) ?></td>
                                    <td><span class="badge bg-light text-dark"><?= htmlspecialchars($apt['TrangThai']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm các biểu đồ, bảng dữ liệu sau -->