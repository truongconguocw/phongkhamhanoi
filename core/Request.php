<?php

namespace Core;

class Request
{
    /**
     * Lấy URI của request hiện tại.
     *
     * @return string
     */
    public static function uri()
    {
        // Lấy URI từ biến server, loại bỏ query string và dấu gạch chéo ở đầu/cuối
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );
    }

    /**
     * Lấy phương thức của request hiện tại (GET, POST, ...).
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD']; // 'GET' hoặc 'POST'
    }
}
