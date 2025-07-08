<?php
/**
 * Đây là file layout chính của ứng dụng.
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tiêu đề trang (được truyền từ Controller) -->
    <title><?= $title ?? 'Phòng khám Hà Nội' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (cho các biểu tượng) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS tùy chỉnh-->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<?php
            require_once __DIR__ . '/header.php';
    ?>

    <!-- Vùng chứa nội dung chính của trang -->
    <main class="container my-4" style="min-height: 70vh;">
        <?php
        // Biến $content sẽ chứa HTML của view cụ thể (ví dụ: login.php, profile.php)
        // Được truyền vào từ BaseController.
        echo $content ?? ''; 
        ?>
    </main>

    <?php
        // Nạp nội dung từ file footer.php
        require_once __DIR__ . '/footer.php';
    ?>

    <!-- SCRIPT LOADING SECTION -->
    <!-- Bootstrap JS (BẮT BUỘC cho dropdown, modal, v.v.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="/js/main.js"></script>

</body>
</html>
