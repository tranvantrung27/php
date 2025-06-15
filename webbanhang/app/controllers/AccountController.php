<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once __DIR__ . '/../utils/JWTHandler.php';

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;
use App\Utils\JWTHandler;

class AccountController
{
    private $accountModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    public function register()
    {
        include_once 'app/views/account/register.php';
    }

    public function login()
    {
        include_once 'app/views/account/login.php';
    }
 public function edit($id)
    {
        SessionHelper::ensureAdmin();

        $account = $this->accountModel->getAccountById($id);
        if (!$account) {
            die("Tài khoản không tồn tại");
        }

        include_once 'app/views/account/edit.php';
    }
public function delete($id)
{
    // Kiểm tra quyền truy cập của người dùng (admin)
    SessionHelper::ensureAdmin();

    // Gọi phương thức xóa tài khoản từ AccountModel
    $result = $this->accountModel->deleteAccount($id);

    if ($result) {
        // Nếu xóa thành công, chuyển hướng về trang quản lý tài khoản và thông báo thành công
        header('Location: /webbanhang/account/manage?message=Account deleted successfully');
    } else {
        // Nếu có lỗi, chuyển hướng và hiển thị thông báo lỗi
        header('Location: /webbanhang/account/manage?error=Failed to delete account');
    }
    exit;
}

    public function createInline()
    {
        SessionHelper::ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            $errors = [];

            if (empty($username)) $errors[] = 'Thiếu username';
            if (empty($fullname)) $errors[] = 'Thiếu fullname';
            if (empty($password)) $errors[] = 'Thiếu password';

            if (!in_array($role, ['admin', 'quanly', 'nhanvien'])) $role = 'nhanvien';

            if ($this->accountModel->getAccountByUsername($username)) {
                $errors[] = 'Tài khoản đã tồn tại';
            }

            if (empty($errors)) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $this->accountModel->save($username, $fullname, $hashed, $role);
            }

            // Bạn có thể flash lỗi ở đây nếu muốn
        }

        header('Location: /webbanhang/account/manage');
        exit;
    }
    public function updateInline($id)
    {
        SessionHelper::ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $role = $_POST['role'] ?? 'nhanvien';

            if (!in_array($role, ['admin', 'quanly', 'nhanvien'])) {
                $role = 'nhanvien';
            }

            $this->accountModel->updateAccountInfo($id, $fullname, $role);
        }

        header('Location: /webbanhang/account/manage');
        exit;
    }
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $errors = [];

            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";

            if (!in_array($role, ['admin', 'user'])) $role = 'user';
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $result = $this->accountModel->save($username, $fullName, $password, $role);
                if ($result) {
                    header('Location: /webbanhang/account/login');
                    exit;
                }
            }
        }
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang/product');
        exit;
    }

    public function checkLogin()
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';

            if(empty($username) || empty($password)) {
                throw new Exception('Username và password không được trống');
            }

            $user = $this->accountModel->getAccountByUserName($username);
            if($user && password_verify($password, $user->password)) {
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
                
                $token = $this->jwtHandler->encode([
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role
                ]);

                echo json_encode([
                    'success' => true,
                    'token' => $token,
                    'user' => [
                        'username' => $user->username,
                        'role' => $user->role
                    ]
                ]);
            } else {
                throw new Exception('Thông tin đăng nhập không hợp lệ');
            }
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function manage()
    {
        SessionHelper::ensureAdmin(); // Tự viết hàm này hoặc kiểm tra role trong hàm

        // Lấy danh sách tài khoản không phải user
        $accounts = $this->accountModel->getStaffAccounts(); // chỉ lấy nhân viên, quản lý, v.v.

        include_once 'app/views/account/manage.php';
    }
    public function updateRoles()
    {
        SessionHelper::ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roles = $_POST['roles'] ?? [];
            $saveFlags = $_POST['save'] ?? [];

            foreach ($saveFlags as $id => $value) {
                $role = $roles[$id] ?? 'user';
                if (in_array($role, ['admin', 'quanly', 'nhanvien'])) {
                    $this->accountModel->updateRole($id, $role);
                }
            }
        }

        header('Location: /webbanhang/account/manage');
        exit;
    }

    public function loginWithGoogle()
    {
        try {
            $client = new Google_Client();
            $client->setClientId('999134715162-dq1m1jjpr3mu9m3mlcgakmianq0majhb.apps.googleusercontent.com');
            $client->setClientSecret('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');
            $client->setRedirectUri('http://localhost:8080/webbanhang/index.php?url=account/googlecallback');






            // Thêm các scope
            $client->addScope('email');
            $client->addScope('profile');
            $client->addScope('openid');

            // Cấu hình thêm
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit;
        } catch (Exception $e) {
            echo "<h3>Lỗi khởi tạo Google Client:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo '<p><a href="/webbanhang/account/login">Quay lại đăng nhập</a></p>';
        }
    }

    public function googlecallback()
    {
        // Bỏ dòng die() debug này
        // die("Đã vào được hàm callback");

        // Kiểm tra lỗi từ Google
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            $errorDescription = $_GET['error_description'] ?? '';

            echo "<h3>Lỗi xác thực Google:</h3>";
            echo "<p><strong>Lỗi:</strong> $error</p>";
            echo "<p><strong>Mô tả:</strong> $errorDescription</p>";

            if ($error === 'access_denied') {
                echo "<p>Bạn đã từ chối cấp quyền. Vui lòng thử lại và cho phép truy cập.</p>";
            }

            echo '<p><a href="/webbanhang/account/login" style="background: #4285f4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Quay lại đăng nhập</a></p>';
            return;
        }

        // Kiểm tra có code không
        if (!isset($_GET['code'])) {
            echo "<h3>Không nhận được mã xác thực từ Google</h3>";
            echo "<p>URL hiện tại: " . $_SERVER['REQUEST_URI'] . "</p>";
            echo '<p><a href="/webbanhang/account/login">Quay lại đăng nhập</a></p>';
            return;
        }

        try {
            $client = new Google_Client();
            $client->setClientId('999134715162-dq1m1jjpr3mu9m3mlcgakmianq0majhb.apps.googleusercontent.com');
            $client->setClientSecret('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');
            $client->setRedirectUri('http://localhost:8080/webbanhang/index.php?url=account/googlecallback');






            // Lấy access token
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (isset($token['error'])) {
                throw new Exception('Lỗi token: ' . ($token['error_description'] ?? $token['error']));
            }

            $client->setAccessToken($token);

            // Lấy thông tin user từ Google
            $oauth = new Google_Service_Oauth2($client);
            $userInfo = $oauth->userinfo->get();

            if (!$userInfo->email) {
                throw new Exception('Không lấy được thông tin email từ Google');
            }

            $username = $userInfo->email;
            $fullName = $userInfo->name ?? $userInfo->email;

            // Kiểm tra tài khoản đã tồn tại chưa
            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                // Tạo tài khoản mới với Google
                $hashedPassword = password_hash(uniqid(), PASSWORD_DEFAULT);
                $result = $this->accountModel->save($username, $fullName, $hashedPassword, 'user');

                if (!$result) {
                    throw new Exception('Không thể tạo tài khoản mới');
                }
            }

            // Đăng nhập thành công
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $account ? $account->role : 'user';

            header('Location: /webbanhang/product');
            exit;
        } catch (Exception $e) {
            echo "<h3>Lỗi xử lý Google callback:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "<p><strong>Debug info:</strong></p>";
            echo "<ul>";
            echo "<li>Code nhận được: " . (isset($_GET['code']) ? 'Có' : 'Không') . "</li>";
            echo "<li>Request URI: " . $_SERVER['REQUEST_URI'] . "</li>";
            echo "</ul>";
            echo '<p><a href="/webbanhang/account/login">Quay lại đăng nhập</a></p>';
        }
    }
   
}
