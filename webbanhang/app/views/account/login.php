<?php include 'app/views/shares/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-3 fw-bold">Đăng nhập</h3>
    <p class="text-center text-muted mb-4">Nhập tên đăng nhập và mật khẩu để tiếp tục</p>

    <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'invalid'): ?>
      <div class="alert alert-warning">Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại.</div>
    <?php elseif (isset($_GET['message']) && $_GET['message'] === 'empty'): ?>
      <div class="alert alert-warning">Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.</div>
    <?php endif; ?>

    <form id="loginForm">
      <div class="mb-3">
        <input type="text" class="form-control form-control-lg" name="username" placeholder="Tên đăng nhập" required>
      </div>
      <div class="mb-3">
        <input type="password" class="form-control form-control-lg" name="password" placeholder="Mật khẩu" required>
      </div>
      <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="#" class="small text-decoration-none">Quên mật khẩu?</a>
        <button type="submit" class="btn btn-primary btn-lg px-5">Đăng nhập</button>
      </div>
    </form>

    <hr>

    <a href="/webbanhang/account/loginwithgoogle" class="btn btn-danger w-100 mb-3">
      <i class="fab fa-google me-2"></i> Đăng nhập bằng Google
    </a>

    <p class="text-center mb-0">Chưa có tài khoản? 
      <a href="/webbanhang/account/register" class="fw-bold text-decoration-none" style="color:#ff8c42;">Đăng ký</a>
    </p>
  </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {
        username: formData.get('username'),
        password: formData.get('password')
    };

    fetch('/webbanhang/account/checkLogin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem('jwtToken', data.token);
            window.location.href = '/webbanhang/product';
        } else {
            alert(data.message || 'Đăng nhập thất bại');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi đăng nhập');
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
