<?php $title = 'Đăng nhập'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header text-center bg-primary text-white">
                <h3 class="mb-0">Đăng nhập tài khoản</h3>
            </div>
            <div class="card-body p-4">
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['error_message']; ?>
                        <?php unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label for="identifier" class="form-label">Email hoặc Số điện thoại</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" value="1">
                        <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button>
                    </div>
                    <hr>
                    <p class="text-center">Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
