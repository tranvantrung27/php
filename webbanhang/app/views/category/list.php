<?php include 'app/views/shares/header.php'; ?>

<h1>Danh sách danh mục</h1>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="/webbanhang/Category/add" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Thêm danh mục mới
        </a>
    </div>
</div>

<div class="row">
    <?php foreach ($categories as $category): ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="category-card">
            <h3 class="category-name">
                <?php echo htmlspecialchars($category->name); ?>
            </h3>
            <p class="category-description">
                <?php echo htmlspecialchars($category->description); ?>
            </p>
            <div class="action-buttons">
                <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Sửa
                </a>
                <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" class="btn btn-danger" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                    <i class="fas fa-trash-alt me-1"></i> Xóa
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>