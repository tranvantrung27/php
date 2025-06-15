<?php
// Chỉ kiểm tra session, không cần start
if (!isset($_SESSION['username'])) {
    echo '<script>
        alert("Vui lòng đăng nhập");
        window.location.href = "/webbanhang/account/login";
    </script>';
    exit;
}

include 'app/views/shares/header.php';
?>

<h1>Danh sách sản phẩm</h1>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/webbanhang/Product/add" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
            </a>
        <?php endif; ?>

    </div>
</div>

<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <div class="product-img-container">
                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                    <?php if ($product->image): ?>
                        <img src="/webbanhang/<?php echo $product->image; ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="product-img">
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-image fa-3x text-secondary"></i>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <div class="product-info">
                <h3 class="product-title">
                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h3>
                <p class="text-muted"><?php echo substr(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'), 0, 100); ?>...</p>
                <div class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ</div>
                <p class="product-category"><small>Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></small></p>

                <div class="action-buttons">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Sửa
                        </a>
                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            <i class="fas fa-trash-alt me-1"></i> Xóa
                        </a>
                    <?php endif; ?>
                    <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary">Thêm vào giỏ hàng</a>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>