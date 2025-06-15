<?php include 'app/views/shares/header.php'; ?>
<div class="container">
    <h1 class="mb-4">Quản lý tài khoản hệ thống</h1>

    <form method="post" action="/webbanhang/account/createInline">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ tên</th>
                    <th>Mật khẩu</th>
                    <th>Phân quyền</th>
                    <th>Thêm</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="username" class="form-control" required></td>
                    <td><input type="text" name="fullname" class="form-control" required></td>
                    <td><input type="password" name="password" class="form-control" required></td>
                    <td>
                        <select name="role" class="form-select">
                            <option value="nhanvien">Nhân viên</option>
                            <option value="quanly">Quản lý</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
                    </td>
                </tr>   
            </tbody>
        </table>
    </form>

    <h4 class="mt-5 mb-3">Danh sách tài khoản hiện tại</h4>



    <form method="post" action="/webbanhang/account/updateRoles">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ tên</th>
                    <th>Phân quyền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
<?php
$editId = $_GET['edit'] ?? null;
?>

<?php foreach ($accounts as $acc): ?>
    <tr>
        <form method="post" action="/webbanhang/account/updateInline/<?= $acc->id ?>">
            <td>
                <?= htmlspecialchars($acc->username) ?>
            </td>
            <td>
                <?php if ($editId == $acc->id): ?>
                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($acc->fullname) ?>" required>
                <?php else: ?>
                    <?= htmlspecialchars($acc->fullname) ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($editId == $acc->id): ?>
                    <select name="role" class="form-select">
                        <option value="nhanvien" <?= $acc->role === 'nhanvien' ? 'selected' : '' ?>>Nhân viên</option>
                        <option value="quanly" <?= $acc->role === 'quanly' ? 'selected' : '' ?>>Quản lý</option>
                        <option value="admin" <?= $acc->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                <?php else: ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars($acc->role) ?></span>
                <?php endif; ?>
            </td>
            <td class="d-flex gap-2">
                <?php if ($editId == $acc->id): ?>
                    <button type="submit" class="btn btn-success btn-sm">Lưu</button>
                    <a href="/webbanhang/account/manage" class="btn btn-secondary btn-sm">Huỷ</a>
                <?php else: ?>
                    <button name="save[<?= $acc->id ?>]" class="btn btn-success btn-sm">Lưu</button>
                    <a href="/webbanhang/account/manage?edit=<?= $acc->id ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="/webbanhang/account/delete/<?= $acc->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xoá tài khoản này không?')">Xoá</a>
                <?php endif; ?>
            </td>
        </form>
    </tr>
<?php endforeach; ?>

            </tbody>
        </table>
    </form>
</div>
<?php include 'app/views/shares/footer.php'; ?>
