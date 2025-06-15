<?php
namespace App\Utils;

require_once __DIR__ . '/../../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JWTHandler {
    private $secret_key;
    private $algorithm;

    public function __construct() {
        $this->secret_key = "your_secret_key_here"; // Thay thế bằng key phức tạp
        $this->algorithm = 'HS256';
    }

    public function encode($data) {
        $issued_at = time();
        $expiration = $issued_at + (60 * 60); // Token hết hạn sau 1 giờ

        $payload = array(
            "iat" => $issued_at,
            "exp" => $expiration,
            "data" => $data
        );

        return JWT::encode($payload, $this->secret_key, $this->algorithm);
    }

    public function decode($token) {
        try {
            return JWT::decode($token, new Key($this->secret_key, $this->algorithm));
        } catch (\Exception $e) {
            return false;
        }
    }
}
?>
