<?php include 'app/views/shares/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sửa Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="text-center mt-5 mb-4">Sửa danh mục</h1>
                <form action="/webbanhang/Category/update" method="POST">
                    <input type="hidden" name="id" value="<?php echo $category->id; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label small">Tên danh mục:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category->name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label small">Mô tả:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($category->description); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="/webbanhang/Category" class="btn btn-secondary">Quay lại danh sách</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'app/views/shares/footer.php'; ?>