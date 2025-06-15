<?php
require_once __DIR__ . '/../utils/JWTHandler.php';
use App\Utils\JWTHandler;

class AuthMiddleware {
    private static $jwtHandler;

    public static function init() {
        self::$jwtHandler = new JWTHandler();
    }

    public static function verifyToken() {
        $headers = getallheaders();
        $token = null;

        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
        }

        if (!$token) {
            http_response_code(401);
            echo json_encode(['message' => 'Token không tồn tại']);
            exit;
        }

        $decoded = self::$jwtHandler->decode($token);
        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['message' => 'Token không hợp lệ']);
            exit;
        }

        return $decoded;
    }
}

AuthMiddleware::init();