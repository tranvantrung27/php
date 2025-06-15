<?php
// Add to the top of your PHP files
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
?>

<link rel="stylesheet" href="/webbanhang/public/css/css_cart/cart.css">
<?php $custom_css = ob_get_clean();
?>
<?php include 'app/views/shares/header.php'; ?>

<div class="cart-container">
    <div class="cart-header">
        <h1><i class="fas fa-shopping-cart me-2"></i>Giỏ hàng của bạn</h1>
    </div>

    <?php if (!empty($cart)): ?>
        <div class="cart-summary">
            <div class="cart-total">
                <?php 
                $totalItems = 0;
                $totalPrice = 0;
                foreach ($cart as $item) {
                    $totalItems += $item['quantity'];
                    $totalPrice += $item['quantity'] * $item['price'];
                }
                ?>
                <p><strong><?php echo $totalItems; ?></strong> sản phẩm trong giỏ hàng</p>
                <h3>Tổng tiền: <span class="price-highlight"><?php echo number_format($totalPrice, 0, ',', '.'); ?> VNĐ</span></h3>
            </div>
        </div>

        <div class="cart-table">
            <div class="cart-table-header">
                <div class="product-info">Sản phẩm</div>
                <div class="product-price">Đơn giá</div>
                <div class="product-quantity">Số lượng</div>
                <div class="product-total">Thành tiền</div>
                <div class="product-action">Thao tác</div>
            </div>

            <?php foreach ($cart as $id => $item): ?>
                <div class="cart-item">
                    <div class="product-info">
                        <div class="product-image">
                            <?php if ($item['image']): ?>
                                <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-details">
                            <h3><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <?php if (!empty($item['category_name'])): ?>
                                <p class="product-category">Danh mục: <?php echo htmlspecialchars($item['category_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="product-price">
                        <?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ
                    </div>
                    <div class="product-quantity">
                        <div class="quantity-control">
                            <a href="/webbanhang/Product/decreaseQuantity/<?php echo $id; ?>" class="quantity-btn decrease">
                                <i class="fas fa-minus"></i>
                            </a>
                            <span class="quantity-value"><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <a href="/webbanhang/Product/increaseQuantity/<?php echo $id; ?>" class="quantity-btn increase">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-total">
                        <?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?> VNĐ
                    </div>
                    <div class="product-action">
                        <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" class="btn-remove" title="Xóa sản phẩm">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-actions">
            <a href="/webbanhang/Product" class="btn-continue">
                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
            </a>
            <a href="/webbanhang/Product/checkout" class="btn-checkout">
                <i class="fas fa-credit-card me-2"></i>Thanh toán
            </a>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart fa-5x"></i>
            <h2>Giỏ hàng của bạn đang trống</h2>
            <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục.</p>
            <a href="/webbanhang/Product" class="btn-shop-now">
                <i class="fas fa-store me-2"></i>Mua sắm ngay
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>