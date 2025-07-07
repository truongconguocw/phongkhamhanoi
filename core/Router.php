<?php

namespace Core;

use Exception;

class Router
{
    /**
     * Mảng chứa tất cả các route đã đăng ký.
     * @var array
     */
    protected array $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Nạp các định nghĩa route từ một file.
     *
     * @param string $file Đường dẫn đến file routes.
     * @return static
     */
    public static function load(string $file): static
    {
        $router = new static;
        require $file;
        return $router;
    }

    /**
     * Đăng ký một route cho phương thức GET.
     *
     * @param string $uri URI của route.
     * @param string $controllerAction Chuỗi 'Controller@method'.
     */
    public function get(string $uri, string $controllerAction): void
    {
        $this->addRoute('GET', $uri, $controllerAction);
    }

    /**
     * Đăng ký một route cho phương thức POST.
     *
     * @param string $uri URI của route.
     * @param string $controllerAction Chuỗi 'Controller@method'.
     */
    public function post(string $uri, string $controllerAction): void
    {
        $this->addRoute('POST', $uri, $controllerAction);
    }

    /**
     * Tìm và thực thi controller cho URI và phương thức request hiện tại.
     *
     * @param string $uri URI từ request.
     * @param string $requestMethod Phương thức request (GET, POST).
     * @return mixed
     * @throws Exception
     */
    public function dispatch(string $uri, string $requestMethod)
    {
        foreach ($this->routes[$requestMethod] as $route => $action) {
            // Kiểm tra xem URI hiện tại có khớp với route đã đăng ký không
            if (preg_match($route, $uri, $matches)) {
                // Tách controller và phương thức từ action
                [$controller, $method] = explode('@', $action);
                $controller = "App\\Controllers\\{$controller}";

                // Lấy các tham số từ URL
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                return $this->callAction($controller, $method, $params);
            }
        }

        throw new Exception("Không tìm thấy route cho URI: {$uri}");
    }

    /**
     * Khởi tạo và gọi phương thức của controller.
     *
     * @param string $controller Tên đầy đủ (namespace) của controller.
     * @param string $method Tên phương thức cần gọi.
     * @param array $params Tham số truyền vào phương thức.
     * @return mixed
     * @throws Exception
     */
    protected function callAction(string $controller, string $method, array $params = []): mixed
    {
        if (!class_exists($controller)) {
            throw new Exception("Controller {$controller} không tồn tại.");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Phương thức {$method} không tồn tại trong controller {$controller}.");
        }

        // Gọi phương thức và truyền các tham số đã lấy được từ URL
        return $controllerInstance->$method(...array_values($params));
    }

    private function addRoute(string $method, string $uri, string $action): void
    {
        // Chuyển đổi URI thành một biểu thức chính quy (regex)
        $uri = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $uri);
        $uri = '#^' . $uri . '$#';

        $this->routes[$method][$uri] = $action;
    }
}