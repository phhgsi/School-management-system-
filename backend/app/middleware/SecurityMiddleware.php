<?php
/**
 * Security Middleware
 * Handles CSRF protection, input validation, and security headers
 */

class SecurityMiddleware {
    private $db;
    private $session;

    public function __construct($db) {
        $this->db = $db;
        $this->session = new Session();
    }

    public function handle() {
        $this->setSecurityHeaders();
        $this->validateCSRFToken();
        $this->sanitizeInput();
        $this->checkRateLimit();
    }

    private function setSecurityHeaders() {
        // Prevent clickjacking
        header('X-Frame-Options: DENY');

        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');

        // Enable XSS protection
        header('X-XSS-Protection: 1; mode=block');

        // Referrer policy
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // Content Security Policy (basic)
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self'");

        // HTTPS enforcement (uncomment if using HTTPS)
        // header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    public function generateCSRFToken() {
        $token = bin2hex(random_bytes(32));
        $this->session->set('csrf_token', $token);
        return $token;
    }

    public function getCSRFToken() {
        return $this->session->get('csrf_token');
    }

    private function validateCSRFToken() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

            if (!$token || !$this->session->has('csrf_token') || !hash_equals($this->session->get('csrf_token'), $token)) {
                http_response_code(403);
                die('CSRF token validation failed');
            }
        }
    }

    private function sanitizeInput() {
        $_GET = $this->sanitizeArray($_GET);
        $_POST = $this->sanitizeArray($_POST);
        $_REQUEST = $this->sanitizeArray($_REQUEST);
    }

    private function sanitizeArray($array) {
        $sanitized = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitizeArray($value);
            } else {
                $sanitized[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }

        return $sanitized;
    }

    private function checkRateLimit() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $currentTime = time();
        $window = 60; // 1 minute
        $maxRequests = 100;

        // Clean old entries (older than 1 minute)
        $this->db->query("DELETE FROM rate_limit WHERE timestamp < :old_time");
        $this->db->bind(':old_time', $currentTime - $window);
        $this->db->execute();

        // Count requests for this IP
        $this->db->query("SELECT COUNT(*) as count FROM rate_limit WHERE ip_address = :ip AND timestamp > :window_start");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':window_start', $currentTime - $window);
        $result = $this->db->single();

        if ($result['count'] >= $maxRequests) {
            http_response_code(429);
            die('Rate limit exceeded. Please try again later.');
        }

        // Add current request
        $this->db->query("INSERT INTO rate_limit (ip_address, timestamp) VALUES (:ip, :timestamp)");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':timestamp', $currentTime);
        $this->db->execute();
    }

    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validatePhone($phone) {
        return preg_match('/^[0-9\-\+\(\)\s]{10,15}$/', $phone);
    }

    public function validatePassword($password) {
        // At least 8 characters, one uppercase, one lowercase, one number
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/', $password);
    }

    public function validateFileUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        return true;
    }

    public function escapeString($string) {
        return mysqli_real_escape_string($this->db->connection, $string);
    }

    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}