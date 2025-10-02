<?php
/**
 * School Management System - Main Entry Point
 * Version: 1.0.0
 */

// Start session
session_start();

// Define constants
define('BASE_PATH', __DIR__);
define('BACKEND_PATH', BASE_PATH . '/backend');
define('ASSETS_PATH', BASE_PATH . '/assets');
define('CONFIG_PATH', BACKEND_PATH . '/config');
define('UPLOADS_PATH', BACKEND_PATH . '/public/uploads');

// Include configuration
require_once CONFIG_PATH . '/database.php';
require_once CONFIG_PATH . '/app.php';

// Include core classes
require_once BACKEND_PATH . '/app/core/Database.php';
require_once BACKEND_PATH . '/app/core/Controller.php';
require_once BACKEND_PATH . '/app/core/Model.php';
require_once BACKEND_PATH . '/app/core/View.php';
require_once BACKEND_PATH . '/app/core/Router.php';
require_once BACKEND_PATH . '/app/core/Session.php';
require_once BACKEND_PATH . '/app/core/Auth.php';

// Include middleware
require_once BACKEND_PATH . '/app/middleware/SecurityMiddleware.php';

// Initialize database connection
try {
    $db = new Database();
    $db->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Initialize session management
$session = new Session();

// Initialize authentication
$auth = new Auth($db);

// Initialize router
$router = new Router($db, $auth);

// Define routes
$router->addRoute('GET', '/', 'HomeController', 'index');
$router->addRoute('GET', '/login', 'AuthController', 'login');
$router->addRoute('POST', '/login', 'AuthController', 'authenticate');
$router->addRoute('GET', '/logout', 'AuthController', 'logout');

// Admin routes
$router->addRoute('GET', '/admin/dashboard', 'AdminController', 'dashboard', ['admin']);
$router->addRoute('GET', '/admin/students', 'AdminController', 'students', ['admin']);
$router->addRoute('GET', '/admin/teachers', 'AdminController', 'teachers', ['admin']);
$router->addRoute('GET', '/admin/classes', 'AdminController', 'classes', ['admin']);
$router->addRoute('GET', '/admin/attendance', 'AdminController', 'attendance', ['admin']);
$router->addRoute('GET', '/admin/exams', 'AdminController', 'exams', ['admin']);
$router->addRoute('GET', '/admin/fees', 'AdminController', 'fees', ['admin']);
$router->addRoute('GET', '/admin/events', 'AdminController', 'events', ['admin']);
$router->addRoute('GET', '/admin/gallery', 'AdminController', 'gallery', ['admin']);
$router->addRoute('GET', '/admin/reports', 'AdminController', 'reports', ['admin']);
$router->addRoute('GET', '/admin/settings', 'AdminController', 'settings', ['admin']);

// Teacher routes
$router->addRoute('GET', '/teacher/dashboard', 'TeacherController', 'dashboard', ['teacher']);
$router->addRoute('GET', '/teacher/classes', 'TeacherController', 'classes', ['teacher']);
$router->addRoute('GET', '/teacher/attendance', 'TeacherController', 'attendance', ['teacher']);
$router->addRoute('GET', '/teacher/exams', 'TeacherController', 'exams', ['teacher']);

// Student routes
$router->addRoute('GET', '/student/dashboard', 'StudentController', 'dashboard', ['student']);
$router->addRoute('GET', '/student/profile', 'StudentController', 'profile', ['student']);
$router->addRoute('GET', '/student/attendance', 'StudentController', 'attendance', ['student']);
$router->addRoute('GET', '/student/results', 'StudentController', 'results', ['student']);
$router->addRoute('GET', '/student/fees', 'StudentController', 'fees', ['student']);

// Cashier routes
$router->addRoute('GET', '/cashier/dashboard', 'CashierController', 'dashboard', ['cashier']);
$router->addRoute('GET', '/cashier/fees', 'CashierController', 'fees', ['cashier']);
$router->addRoute('GET', '/cashier/reports', 'CashierController', 'reports', ['cashier']);

// API routes
$router->addRoute('GET', '/api/students', 'ApiController', 'getStudents');
$router->addRoute('GET', '/api/teachers', 'ApiController', 'getTeachers');
$router->addRoute('GET', '/api/classes', 'ApiController', 'getClasses');
$router->addRoute('GET', '/api/attendance', 'ApiController', 'getAttendance');
$router->addRoute('GET', '/api/fees', 'ApiController', 'getFees');

// Handle request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);