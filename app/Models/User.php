<?php

namespace App\Models;

use PDO;

class User extends BaseModel
{
    protected string $table = 'nguoidung';
    protected string $primaryKey = 'UserID';

    /**
     * Tìm một người dùng dựa trên địa chỉ email.
     *
     * @param string $email Địa chỉ email cần tìm.
     * @return array|false Trả về mảng thông tin người dùng nếu tìm thấy, ngược lại trả về false.
     */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm người dùng bằng email hoặc số điện thoại.
     * @param string $identifier Email hoặc SĐT
     * @return array|false
     */
    public function findByIdentifier(string $identifier)
    {
        $sql = "SELECT * FROM {$this->table} WHERE Email = ? OR SoDienThoai = ?";
        $stmt = $this->query($sql, [$identifier, $identifier]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /**
     * Đếm số lượng người dùng theo vai trò.
     * @param string $role
     * @return int
     */
    public function countByRole(string $role): int
    {
        return $this->countWhere('VaiTro', $role);
    }

    // ... (phương thức createAuthToken) ...
    public function createAuthToken(int $userId, string $selector, string $validatorHash, string $expiresAt): void
    {
        // Xóa các token cũ của user này để tránh rác
        $this->query("DELETE FROM auth_tokens WHERE UserID = ?", [$userId]);
        $sql = "INSERT INTO auth_tokens (UserID, Selector, ValidatorHash, ExpiresAt) VALUES (?, ?, ?, ?)";
        $this->query($sql, [$userId, $selector, $validatorHash, $expiresAt]);
    }

    /**
     * Tìm người dùng dựa trên token "Ghi nhớ".
     */
    public function findUserByToken(string $selector, string $validator)
    {
        $sql = "SELECT * FROM auth_tokens WHERE Selector = ? AND ExpiresAt >= NOW()";
        $stmt = $this->query($sql, [$selector]);
        $token = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($token && password_verify($validator, $token['ValidatorHash'])) {
            // Token hợp lệ, trả về thông tin người dùng
            return $this->find($token['UserID']);
        }

        // Token không hợp lệ hoặc hết hạn -> xóa token
        if ($token) {
            $this->query("DELETE FROM auth_tokens WHERE TokenID = ?", [$token['TokenID']]);
        }
        
        return false;
    }

    /**
     * Xóa token "Ghi nhớ" bằng selector.
     */
    public function deleteAuthTokenBySelector(string $selector): void
    {
        $this->query("DELETE FROM auth_tokens WHERE Selector = ?", [$selector]);
    }
}
