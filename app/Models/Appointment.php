<?php
namespace App\Models;
use PDO;

class Appointment extends BaseModel
{
    protected string $table = 'lichkham';
    protected string $primaryKey = 'LichKhamID';

    /**
     * Lấy danh sách lịch hẹn cho một bác sĩ vào một ngày cụ thể.
     * @param int $doctorId
     * @param string $date (YYYY-MM-DD)
     * @param bool $withPatientDetails
     * @return array
     */
    public function getAppointmentsForDoctorByDate(int $doctorId, string $date, bool $withPatientDetails = false): array
    {
        $startOfDay = $date . ' 00:00:00';
        $endOfDay = $date . ' 23:59:59';

        $selectClause = $withPatientDetails 
            ? "lk.*, bn.HoTen AS TenBenhNhan, bn.NgaySinh, bn.GioiTinh"
            : "lk.*";

        $sql = "SELECT {$selectClause}
                FROM {$this->table} AS lk";
        
        if ($withPatientDetails) {
            $sql .= " JOIN benhnhan AS bn ON lk.BenhNhanID = bn.BenhNhanID";
        }

        $sql .= " WHERE lk.BacSiID = ? AND lk.ThoiGianKham BETWEEN ? AND ?
                  ORDER BY lk.ThoiGianKham ASC";

        $stmt = $this->query($sql, [$doctorId, $startOfDay, $endOfDay]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy danh sách lịch hẹn của một bác sĩ, kèm theo tên bệnh nhân.
     *
     * @param int $doctorId ID của bác sĩ.
     * @return array Danh sách các lịch hẹn.
     */
    public function findByDoctorId(int $doctorId): array
    {
        $sql = "SELECT 
                    lk.LichKhamID, lk.ThoiGianKham, lk.TrangThai, lk.LyDoKham,
                    bn.HoTen AS TenBenhNhan
                FROM {$this->table} AS lk
                JOIN benhnhan AS bn ON lk.BenhNhanID = bn.BenhNhanID
                WHERE lk.BacSiID = ?
                ORDER BY lk.ThoiGianKham DESC";
        
        $stmt = $this->query($sql, [$doctorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin chi tiết của một lịch hẹn.
     *
     * @param int $appointmentId ID của lịch hẹn.
     * @return array|false Dữ liệu lịch hẹn hoặc false nếu không tìm thấy.
     */
    public function findDetailsById(int $appointmentId): array|false
    {
        $sql = "SELECT 
                    lk.*, 
                    bn.HoTen AS TenBenhNhan, bn.NgaySinh, bn.GioiTinh, bn.SoDienThoai AS SDTBenhNhan,
                    bs_u.HoTen AS TenBacSi
                    
                FROM {$this->table} AS lk
                JOIN benhnhan AS bn ON lk.BenhNhanID = bn.BenhNhanID
                JOIN bacsi AS bs ON lk.BacSiID = bs.BacSiID
                JOIN nguoidung AS bs_u ON bs.UserID = bs_u.UserID
                WHERE lk.LichKhamID = ?";

        $stmt = $this->query($sql, [$appointmentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tất cả lịch hẹn của một bệnh nhân, kèm theo thông tin bác sĩ.
     * @param int $patientId ID của bệnh nhân.
     * @return array
     */
    public function findAllByPatientIdWithDoctor(int $patientId): array
    {
        $sql = "SELECT 
                    lk.*, 
                    u.HoTen AS TenBacSi
                FROM {$this->table} AS lk
                JOIN bacsi AS bs ON lk.BacSiID = bs.BacSiID
                JOIN nguoidung AS u ON bs.UserID = u.UserID
                WHERE lk.BenhNhanID = ?
                ORDER BY lk.ThoiGianKham DESC";
        
        $stmt = $this->query($sql, [$patientId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Đếm số lịch hẹn theo trạng thái.
     * @param string $status
     * @return int
     */
    public function countByStatus(string $status): int
    {
        return $this->countWhere('TrangThai', $status);
    }

    /**
     * Đếm số lịch hẹn đã hoàn thành trong ngày hôm nay.
     * @return int
     */
    public function countCompletedToday(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE TrangThai = 'DaHoanThanh' AND DATE(ThoiGianKham) = CURDATE()";
        $stmt = $this->query($sql);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Lấy các lịch hẹn gần đây nhất.
     * @param int $limit Số lượng bản ghi cần lấy.
     * @return array
     */
    public function getRecentAppointments(int $limit = 5): array
    {
        $sql = "SELECT 
                    lk.ThoiGianKham, lk.TrangThai,
                    p_user.HoTen AS TenBenhNhan,
                    d_user.HoTen AS TenBacSi
                FROM {$this->table} AS lk
                JOIN benhnhan AS p ON lk.BenhNhanID = p.BenhNhanID
                JOIN nguoidung AS p_user ON p.UserID = p_user.UserID
                JOIN bacsi AS d ON lk.BacSiID = d.BacSiID
                JOIN nguoidung AS d_user ON d.UserID = d_user.UserID
                ORDER BY lk.NgayDatLich DESC
                LIMIT ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tất cả lịch hẹn cho trang quản trị, có hỗ trợ lọc.
     * @param array $filters Mảng các bộ lọc (status, doctor_id, date).
     * @return array
     */
    public function getAllAppointmentsForAdmin(array $filters = []): array
    {
        $sql = "SELECT 
                    lk.LichKhamID, lk.ThoiGianKham, lk.TrangThai,
                    bn.HoTen AS TenBenhNhan,
                    u.HoTen AS TenBacSi,
                    bn.SoDienThoai AS SoDienThoaiBenhNhan
                    
                FROM {$this->table} AS lk
                JOIN benhnhan AS bn ON lk.BenhNhanID = bn.BenhNhanID
                JOIN bacsi AS bs ON lk.BacSiID = bs.BacSiID
                JOIN nguoidung AS u ON bs.UserID = u.UserID";
        
        $whereClauses = [];
        $params = [];

        if (!empty($filters['status'])) {
            $whereClauses[] = "lk.TrangThai = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['doctor_id'])) {
            $whereClauses[] = "lk.BacSiID = ?";
            $params[] = $filters['doctor_id'];
        }
        if (!empty($filters['date'])) {
            $whereClauses[] = "DATE(lk.ThoiGianKham) = ?";
            $params[] = $filters['date'];
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $sql .= " ORDER BY lk.ThoiGianKham DESC";

        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách lịch hẹn của một bác sĩ, có thể lọc theo trạng thái.
     *
     * @param int $doctorId ID của bác sĩ.
     * @param ?string $status Trạng thái cần lọc (ví dụ: 'ChoXacNhan', 'DaHoanThanh'). Nếu null, lấy tất cả.
     * @return array Danh sách các lịch hẹn.
     */
    public function getAppointmentsForDoctor(int $doctorId, ?string $status = null): array
    {
        $params = [$doctorId];
        $sql = "SELECT 
                    lk.LichKhamID, lk.ThoiGianKham, lk.TrangThai, lk.LyDoKham,
                    bn.HoTen AS TenBenhNhan
                FROM {$this->table} AS lk
                JOIN benhnhan AS bn ON lk.BenhNhanID = bn.BenhNhanID
                WHERE lk.BacSiID = ?";

        if ($status) {
            $sql .= " AND lk.TrangThai = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY lk.ThoiGianKham DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy số lượng lịch hẹn mỗi ngày trong 7 ngày qua.
     * @return array
     */
    public function getAppointmentCountLast7Days(): array
    {
        $sql = "SELECT DATE(ThoiGianKham) as appointment_date, COUNT(LichKhamID) as appointment_count
                FROM {$this->table}
                WHERE ThoiGianKham >= CURDATE() - INTERVAL 6 DAY AND ThoiGianKham < CURDATE() + INTERVAL 1 DAY
                GROUP BY DATE(ThoiGianKham)
                ORDER BY appointment_date ASC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy các dịch vụ được sử dụng nhiều nhất.
     * @param int $limit
     * @return array
     */
    public function getTopServiceUsage(int $limit = 5): array
    {
        $sql = "SELECT 
                    dd.TenDichVu, 
                    COUNT(cdvk.ChiTietID) as usage_count
                FROM chitietdichvukham AS cdvk
                JOIN danhmucdichvu AS dd ON cdvk.DichVuID = dd.DichVuID
                GROUP BY dd.TenDichVu
                ORDER BY usage_count DESC
                LIMIT ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy hoạt động của các bác sĩ trong ngày hôm nay.
     * @return array
     */
    public function getDoctorActivityToday(): array
    {
        $sql = "SELECT 
                    u.HoTen AS TenBacSi,
                    COUNT(lk.LichKhamID) AS SoLichHen
                FROM {$this->table} AS lk
                JOIN bacsi AS bs ON lk.BacSiID = bs.BacSiID
                JOIN nguoidung AS u ON bs.UserID = u.UserID
                WHERE DATE(lk.ThoiGianKham) = CURDATE()
                GROUP BY u.HoTen
                ORDER BY SoLichHen DESC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
