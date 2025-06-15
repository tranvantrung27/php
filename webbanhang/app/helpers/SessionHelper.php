<?php
class SessionHelper
{
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function isLoggedIn()
    {
        return isset($_SESSION['username']) && !empty($_SESSION['username']);
    }
    public static function isAdmin()
    {
        self::start();
        return isset($_SESSION['username']) && isset($_SESSION['role']) &&
            $_SESSION['role'] === 'admin';
    }
    public static function getRole()
    {
        self::start();
        return $_SESSION['role'] ?? 'guest';
    }
    // Thêm phương thức kiểm tra role cụ thể
    public static function hasRole($role)
    {
        self::start();
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }
    
    public static function ensureAdmin()
    {
        if (!self::isAdmin()) {
            header('Location: /webbanhang/account/login');
            exit;
        }
    }

    public static function setUserSession($userData)
    {
        self::start();
        $_SESSION['username'] = $userData['username'];
        $_SESSION['role'] = $userData['role'];
    }

    public static function clearSession()
    {
        self::start();
        session_destroy();
    }

    public static function getUserData()
    {
        self::start();
        return [
            'username' => $_SESSION['username'] ?? null,
            'role' => $_SESSION['role'] ?? null
        ];
    }
}
