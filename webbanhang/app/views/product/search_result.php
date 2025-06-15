<?php include 'app/views/shares/header.php'; ?>

<h2>Kết quả tìm kiếm cho: <em><?= htmlspecialchars($_GET['keyword']) ?></em></h2>

<?php if (!empty($products)): ?>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if ($product->image): ?>
                        <img src="/webbanhang/<?= $product->image ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                        <p class="card-text"><?= substr(htmlspecialchars($product->description), 0, 100) ?>...</p>
                        <p class="card-text"><strong><?= number_format($product->price, 0, ',', '.') ?> VNĐ</strong></p>
                        <a href="/webbanhang/Product/show/<?= $product->id ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Không tìm thấy sản phẩm nào phù hợp.</div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
