<?php include 'app/views/shares/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Thêm Danh Mục Mới</h2>
        <form action="/webbanhang/Category/store" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Tên Danh Mục</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô Tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Mới</button>
            <a href="/webbanhang/Category" class="btn btn-secondary">Quay Lại</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'app/views/shares/footer.php'; ?>