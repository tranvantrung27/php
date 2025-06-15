<head>
    <link href="public/css/css_footer/footer.css" rel="stylesheet">
   
</head>
<body>
    <div class="container">
    </div>
    <footer class="footer mt-5 py-4 bg-light">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Quản Lý Sản Phẩm | <i class="fas fa-code text-primary"></i> Trần Văn Trung <i class="fas fa-heart text-danger"></i></p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Thêm animation cho các phần tử khi load trang
        document.addEventListener('DOMContentLoaded', function() {
            const listItems = document.querySelectorAll('.list-group-item, .card, .product-card, .category-card');
            listItems.forEach((item, index) => {
                item.classList.add('animated');
                item.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
