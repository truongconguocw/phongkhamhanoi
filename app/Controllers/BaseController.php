<?php

namespace App\Controllers;

/**
 * Class BaseController
 * Lớp controller cơ sở, chứa các phương thức chung mà các controller khác có thể kế thừa.
 */
abstract class BaseController
{
    /**
     * Render một view và bọc nó trong một layout.
     * @param string $view Tên file view.
     * @param array $data Dữ liệu cần truyền cho view.
     * @param ?string $layout Tên file layout. Nếu null, chỉ render view.
     */
    protected function render(string $view, array $data = [], ?string $layout = 'main')
    {
        // Biến các key của mảng $data thành các biến riêng lẻ
        extract($data);

        // Bắt đầu bộ đệm đầu ra để "bắt" nội dung của file view
        ob_start();
        
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view tại: " . htmlspecialchars($viewFile);
        }
        
        // Lấy nội dung đã "bắt" được và lưu vào biến $content
        $content = ob_get_clean();

        // File layout sẽ sử dụng biến $content ở trên.
        if ($layout) {
            $layoutFile = __DIR__ . '/../Views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo "Lỗi: Không tìm thấy file layout tại: " . htmlspecialchars($layoutFile);
            }
        } else {
            // Nếu không có layout, chỉ hiển thị nội dung của view
            echo $content;
        }
    }

    /**
     * Chuyển hướng người dùng đến một URL khác.
     *
     * @param string $url URL đích (ví dụ: '/login' hoặc 'https://example.com').
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit();
    }

    /**
     * Trả về phản hồi dưới dạng JSON.
     * Hữu ích cho các yêu cầu API hoặc AJAX.
     *
     * @param array $data Dữ liệu cần chuyển thành JSON.
     * @param int $statusCode Mã trạng thái HTTP (mặc định là 200 OK).
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        // Thiết lập mã trạng thái HTTP
        http_response_code($statusCode);
        // Thiết lập header để trình duyệt biết đây là phản hồi JSON
        header('Content-Type: application/json; charset=utf-8');
        // In ra chuỗi JSON và kết thúc script
        echo json_encode($data);
        exit();
    }



}
