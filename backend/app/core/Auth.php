<?php
/**
 * Authentication Class
 * Handles user authentication and authorization
 */

class Auth {
    private $db;
    private $session;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->session = new Session();
        $this->loadUser();
    }

    private function loadUser() {
        if ($this->session->has('user_id')) {
            $userId = $this->session->get('user_id');
            $this->user = $this->getUserById($userId);
        }
    }

    public function login($username, $password) {
        // Get user by username or email
        $user = $this->getUserByUsername($username);

        if (!$user) {
            return false;
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Check if user is active
        if ($user['status'] !== 'active') {
            return false;
        }

        // Set session data
        $this->session->set('user_id', $user['id']);
        $this->session->set('user_role', $user['role']);
        $this->session->set('user_name', $user['first_name'] . ' ' . $user['last_name']);
        $this->session->set('login_time', time());

        // Update last login
        $this->updateLastLogin($user['id']);

        // Load user data
        $this->user = $user;

        return true;
    }

    public function logout() {
        $this->session->remove('user_id');
        $this->session->remove('user_role');
        $this->session->remove('user_name');
        $this->session->remove('login_time');
        $this->user = null;
    }

    public function isLoggedIn() {
        return $this->session->has('user_id') && $this->user !== null;
    }

    public function getCurrentUser() {
        return $this->user;
    }

    public function getUserId() {
        return $this->session->get('user_id');
    }

    public function getUserRole() {
        return $this->session->get('user_role');
    }

    public function getUserName() {
        return $this->session->get('user_name');
    }

    public function hasRole($roles) {
        if (!$this->isLoggedIn()) {
            return false;
        }

        $userRole = $this->getUserRole();

        if (is_array($roles)) {
            return in_array($userRole, $roles);
        }

        return $userRole === $roles;
    }

    public function hasPermission($permission) {
        if (!$this->isLoggedIn()) {
            return false;
        }

        // Get user role permissions from database
        $this->db->query("SELECT permissions FROM roles WHERE role_name = :role");
        $this->db->bind(':role', $this->getUserRole());
        $role = $this->db->single();

        if (!$role) {
            return false;
        }

        $permissions = json_decode($role['permissions'], true);

        return isset($permissions[$permission]) && $permissions[$permission];
    }

    public function check() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }

    public function requireRole($roles) {
        if (!$this->hasRole($roles)) {
            http_response_code(403);
            echo 'Access denied';
            exit;
        }
    }

    private function getUserByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username OR email = :email");
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $username);
        return $this->db->single();
    }

    private function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    private function updateLastLogin($userId) {
        $this->db->query("UPDATE users SET last_login = NOW() WHERE id = :id");
        $this->db->bind(':id', $userId);
        $this->db->execute();
    }

    private function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function generateToken() {
        return bin2hex(random_bytes(32));
    }

    public function getRememberToken() {
        return $this->session->get('remember_token');
    }

    public function setRememberToken($token) {
        $this->session->set('remember_token', $token);
    }
}