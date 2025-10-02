<?php
/**
 * Authentication Controller
 * Handles login, logout, and authentication-related operations
 */

class AuthController extends Controller {
    private $security;

    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        $this->security = new SecurityMiddleware($db);
    }

    public function login() {
        // Check if already logged in
        if ($this->auth->isLoggedIn()) {
            $this->redirectToDashboard();
        }

        $data = [
            'title' => 'Login - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken(),
            'error' => $this->auth->session->getFlash('error'),
            'success' => $this->auth->session->getFlash('success')
        ];

        $this->view('auth/login', $data);
    }

    public function authenticate() {
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!$csrfToken || !$this->auth->session->has('csrf_token') || !hash_equals($this->auth->session->get('csrf_token'), $csrfToken)) {
            $this->auth->session->setFlash('error', 'Invalid request token');
            $this->redirect('/login');
        }

        // Get form data
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        // Validate input
        if (empty($username) || empty($password)) {
            $this->auth->session->setFlash('error', 'Please enter both username and password');
            $this->redirect('/login');
        }

        // Check login attempts
        if (!$this->checkLoginAttempts()) {
            $this->auth->session->setFlash('error', 'Too many failed attempts. Please try again later.');
            $this->redirect('/login');
        }

        // Attempt login
        if ($this->auth->login($username, $password)) {
            // Reset login attempts on successful login
            $this->resetLoginAttempts();

            // Set remember me token if requested
            if ($remember) {
                $token = $this->auth->generateToken();
                $this->auth->setRememberToken($token);
                // Store token in database for persistent login
            }

            $this->redirectToDashboard();
        } else {
            // Increment failed attempts
            $this->incrementLoginAttempts();

            $this->auth->session->setFlash('error', 'Invalid username or password');
            $this->redirect('/login');
        }
    }

    public function logout() {
        $this->auth->logout();
        $this->redirect('/login');
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email) || !$this->security->validateEmail($email)) {
                $this->auth->session->setFlash('error', 'Please enter a valid email address');
                $this->redirect('/forgot-password');
            }

            // Check if email exists in system
            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if ($user) {
                // Generate reset token
                $token = $this->auth->generateToken();
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Save reset token to database
                $userModel->savePasswordResetToken($user['id'], $token, $expiry);

                // Send reset email (implement email sending)
                // $this->sendPasswordResetEmail($email, $token);

                $this->auth->session->setFlash('success', 'Password reset instructions have been sent to your email');
            } else {
                $this->auth->session->setFlash('success', 'If the email exists, password reset instructions have been sent');
            }

            $this->redirect('/forgot-password');
        }

        $data = [
            'title' => 'Forgot Password - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('auth/forgot_password', $data);
    }

    private function redirectToDashboard() {
        $role = $this->auth->getUserRole();

        switch ($role) {
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'teacher':
                $this->redirect('/teacher/dashboard');
                break;
            case 'student':
                $this->redirect('/student/dashboard');
                break;
            case 'parent':
                $this->redirect('/parent/dashboard');
                break;
            case 'cashier':
                $this->redirect('/cashier/dashboard');
                break;
            default:
                $this->redirect('/');
        }
    }

    private function checkLoginAttempts() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $attempts = $this->auth->session->get('login_attempts', 0);
        $lastAttempt = $this->auth->session->get('last_attempt', 0);

        // Reset attempts if it's been more than 15 minutes
        if (time() - $lastAttempt > 900) {
            $this->resetLoginAttempts();
            return true;
        }

        return $attempts < LOGIN_ATTEMPTS;
    }

    private function incrementLoginAttempts() {
        $attempts = $this->auth->session->get('login_attempts', 0);
        $this->auth->session->set('login_attempts', $attempts + 1);
        $this->auth->session->set('last_attempt', time());
    }

    private function resetLoginAttempts() {
        $this->auth->session->remove('login_attempts');
        $this->auth->session->remove('last_attempt');
    }
}