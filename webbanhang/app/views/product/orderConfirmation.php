<?php include 'app/views/shares/header.php'; ?>

<!-- Gọi file CSS -->
<link rel="stylesheet" href="/webbanhang/public/css/css_cart/order_success.css">

<div class="success-page">
    <!-- Hiệu ứng Confetti -->
    <?php for ($i = 1; $i <= 20; $i++): ?>
        <div class="confetti" style="left: <?php echo rand(1, 100); ?>%; top: <?php echo rand(1, 100); ?>%; 
            background-color: <?php 
                $colors = ['#34bfa3', '#ff7675', '#fdcb6e', '#74b9ff', '#a29bfe', '#55efc4', '#fab1a0', '#81ecec', '#ffeaa7']; 
                echo $colors[array_rand($colors)]; 
            ?>;
            width: <?php echo rand(5, 15); ?>px;
            height: <?php echo rand(5, 15); ?>px;
            animation-delay: <?php echo $i * 0.2; ?>s;"></div>
    <?php endfor; ?>

    <div class="success-container">
        <div class="animation-container">
            <div class="animation-circle"></div>
            <div class="animation-check">
                <i class="fas fa-check"></i>
            </div>
        </div>
        
        <div class="success-content">
            <h1>Đặt hàng thành công!</h1>
            <p class="order-number">Mã đơn hàng: <span>#<?php echo isset($orderCode) ? $orderCode : rand(100000, 999999); ?></span></p>
            <div class="success-message">
                <p>Cảm ơn bạn đã tin tưởng và mua hàng tại cửa hàng chúng tôi.</p>
                <p>Đơn hàng của bạn đang được xử lý và sẽ sớm được giao đến tay bạn.</p>
                <p>Bạn sẽ nhận được email xác nhận đơn hàng trong vòng vài phút.</p>
            </div>
            
            <div class="order-summary">
                <h3>Thông tin đơn hàng</h3>
                <div class="summary-items">
                    <div class="summary-item">
                        <i class="fas fa-calendar"></i>
                        <div>
                            <span>Ngày đặt hàng</span>
                            <strong><?php echo date('d/m/Y'); ?></strong>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <i class="fas fa-truck"></i>
                        <div>
                            <span>Dự kiến giao hàng</span>
                            <strong><?php echo date('d/m/Y', strtotime('+3 days')); ?></strong>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <i class="fas fa-credit-card"></i>
                        <div>
                            <span>Phương thức</span>
                            <strong><?php echo isset($paymentMethod) ? $paymentMethod : 'Thanh toán khi nhận hàng'; ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="/webbanhang/Order/history" class="btn-view-order">
                    <i class="fas fa-receipt me-2"></i>Xem đơn hàng
                </a>
                <a href="/webbanhang/Product" class="btn-shop">
                    <i class="fas fa-store me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
        
        <div class="success-footer">
            <div class="contact-info">
                <p>Mọi thắc mắc xin liên hệ: <strong>hotline@webbanhang.com</strong> hoặc gọi <strong>1900 1234</strong></p>
            </div>
        </div>
    </div>
</div>

<!-- Thêm JavaScript để hiệu ứng confetti chạy liên tục -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thêm hiệu ứng confetti liên tục
    const confettiContainer = document.querySelector('.success-page');
    
    function createConfetti() {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        
        // Vị trí ngẫu nhiên
        const posX = Math.random() * 100;
        confetti.style.left = posX + '%';
        confetti.style.top = '100%';
        
        // Kích thước ngẫu nhiên
        const size = Math.random() * 10 + 5;
        confetti.style.width = size + 'px';
        confetti.style.height = size + 'px';
        
        // Màu sắc ngẫu nhiên
        const colors = ['#34bfa3', '#ff7675', '#fdcb6e', '#74b9ff', '#a29bfe', '#55efc4', '#fab1a0', '#81ecec', '#ffeaa7'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.backgroundColor = randomColor;
        
        // Hình dạng ngẫu nhiên
        const shapes = ['circle', 'square', 'triangle'];
        const randomShape = shapes[Math.floor(Math.random() * shapes.length)];
        if (randomShape === 'circle') {
            confetti.style.borderRadius = '50%';
        } else if (randomShape === 'triangle') {
            confetti.style.width = '0';
            confetti.style.height = '0';
            confetti.style.backgroundColor = 'transparent';
            confetti.style.borderLeft = size/2 + 'px solid transparent';
            confetti.style.borderRight = size/2 + 'px solid transparent';
            confetti.style.borderBottom = size + 'px solid ' + randomColor;
        }
        
        // Thêm hiệu ứng animation
        confetti.style.animation = 'confetti ' + (Math.random() * 3 + 2) + 's ease-in-out infinite';
        
        // Thêm vào container
        confettiContainer.appendChild(confetti);
        
        // Xóa confetti sau khi kết thúc animation
        setTimeout(() => {
            confetti.remove();
        }, 5000);
    }
    
    // Tạo confetti liên tục
    setInterval(createConfetti, 300);
});
</script>

<?php include 'app/views/shares/footer.php'; ?>