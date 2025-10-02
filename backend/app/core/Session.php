<?php
/**
 * Session Management Class
 * Handles secure session operations
 */

class Session {
    private $sessionName = 'SMS_SESSION';
    private $lifetime = 3600; // 1 hour

    public function __construct() {
        $this->start();
        $this->setCookieParams();
    }

    private function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_name($this->sessionName);
            session_start();
        }
    }

    private function setCookieParams() {
        $secure = isset($_SERVER['HTTPS']);
        $httponly = true;
        $samesite = 'Strict';

        session_set_cookie_params([
            'lifetime' => $this->lifetime,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'] ?? '',
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy() {
        session_unset();
        session_destroy();

        // Delete session cookie
        if (isset($_COOKIE[$this->sessionName])) {
            setcookie($this->sessionName, '', time() - 3600, '/');
        }
    }

    public function regenerateId() {
        session_regenerate_id(true);
    }

    public function getId() {
        return session_id();
    }

    public function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }

    public function getFlash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }

    public function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }

    public function getAllFlash() {
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flash;
    }

    public function isExpired() {
        $lastActivity = $this->get('last_activity', 0);
        return (time() - $lastActivity) > $this->lifetime;
    }

    public function updateActivity() {
        $this->set('last_activity', time());
    }

    public function __get($key) {
        return $this->get($key);
    }

    public function __set($key, $value) {
        $this->set($key, $value);
    }

    public function __isset($key) {
        return $this->has($key);
    }

    public function __unset($key) {
        $this->remove($key);
    }
}