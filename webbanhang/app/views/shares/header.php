<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng của Trung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="/webbanhang/public/css/style.css" rel="stylesheet">

    <?php if (isset($custom_css)) echo $custom_css; ?>


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/webbanhang/Product"><i class="fas fa-store me-2"></i>Trung Luxury </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto align-items-center">
        <?php if (SessionHelper::isLoggedIn() && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link" href="/webbanhang/Product/add"><i class="fas fa-plus me-1"></i> Thêm sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/webbanhang/Category"><i class="fas fa-tags me-1"></i> Danh mục</a>
            </li>
        <?php elseif (SessionHelper::isLoggedIn() && $_SESSION['role'] === 'user'): ?>
            <!-- Ô tìm kiếm chỉ hiển thị cho user -->
            <form class="d-flex ms-2" action="/webbanhang/Product/search" method="get">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm sản phẩm..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
            </form>
        <?php endif; ?>

        <li class="nav-item ms-3">
            <a class="nav-link" href="/webbanhang/Product/cart"><i class="fas fa-shopping-cart me-1"></i> Giỏ Hàng</a>
        </li>
    </ul>

<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <?php if (SessionHelper::isLoggedIn()): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user me-1"></i> <?= $_SESSION['username']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                    <li><a class="dropdown-item" href="/webbanhang/account/manage">Quản lý tài khoản</a></li>
                    <li><a class="dropdown-item" href="/webbanhang/account/register">Tạo tài khoản mới</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/webbanhang/account/logout"><i class="fas fa-sign-out-alt me-1"></i> Đăng xuất</a></li>
                </ul>
            <?php else: ?>
                <a class="nav-link" href="#"><i class="fas fa-user me-1"></i> <?= $_SESSION['username']; ?></a>
                <a class="nav-link" href="/webbanhang/account/logout"><i class="fas fa-sign-out-alt me-1"></i> Đăng xuất</a>
            <?php endif; ?>
        <?php else: ?>
            <a class="nav-link" href="/webbanhang/account/login"><i class="fas fa-sign-in-alt me-1"></i> Đăng nhập</a>
        <?php endif; ?>
    </li>
</ul>

</div>


        </div>
    </nav>
    <script>
function logout() {
localStorage.removeItem('jwtToken');
location.href = '/webbanhang/account/login';
}
document.addEventListener("DOMContentLoaded", function() {
const token = localStorage.getItem('jwtToken');
if (token) {
document.getElementById('nav-login').style.display = 'none';
document.getElementById('nav-logout').style.display = 'block';
} else {
document.getElementById('nav-login').style.display = 'block';
document.getElementById('nav-logout').style.display = 'none';
}
});
</script>
    <div class="container mt-5 animated">