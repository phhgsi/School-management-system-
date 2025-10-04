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
    if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
        $db->connect('', ''); // SQLite doesn't need host/dbname for connection
    } else {
        $db->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
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
$router->addRoute('POST', '/admin/students/add', 'AdminController', 'addStudent', ['admin']);
$router->addRoute('GET', '/admin/students/edit/{id}', 'AdminController', 'editStudent', ['admin']);
$router->addRoute('POST', '/admin/students/edit/{id}', 'AdminController', 'editStudent', ['admin']);
$router->addRoute('POST', '/admin/students/delete/{id}', 'AdminController', 'deleteStudent', ['admin']);
$router->addRoute('GET', '/admin/students/view/{id}', 'AdminController', 'viewStudent', ['admin']);
$router->addRoute('GET', '/admin/teachers', 'AdminController', 'teachers', ['admin']);
$router->addRoute('POST', '/admin/teachers/add', 'AdminController', 'addTeacher', ['admin']);
$router->addRoute('GET', '/admin/teachers/edit/{id}', 'AdminController', 'editTeacher', ['admin']);
$router->addRoute('POST', '/admin/teachers/edit/{id}', 'AdminController', 'editTeacher', ['admin']);
$router->addRoute('POST', '/admin/teachers/delete/{id}', 'AdminController', 'deleteTeacher', ['admin']);
$router->addRoute('GET', '/admin/teachers/view/{id}', 'AdminController', 'viewTeacher', ['admin']);
$router->addRoute('GET', '/admin/classes', 'AdminController', 'classes', ['admin']);
$router->addRoute('POST', '/admin/classes/add', 'AdminController', 'addClass', ['admin']);
$router->addRoute('GET', '/admin/classes/edit/{id}', 'AdminController', 'editClass', ['admin']);
$router->addRoute('POST', '/admin/classes/edit/{id}', 'AdminController', 'editClass', ['admin']);
$router->addRoute('POST', '/admin/classes/delete/{id}', 'AdminController', 'deleteClass', ['admin']);
$router->addRoute('POST', '/admin/subjects/add', 'AdminController', 'addSubject', ['admin']);
$router->addRoute('GET', '/admin/subjects/edit/{id}', 'AdminController', 'editSubject', ['admin']);
$router->addRoute('POST', '/admin/subjects/edit/{id}', 'AdminController', 'editSubject', ['admin']);
$router->addRoute('POST', '/admin/subjects/delete/{id}', 'AdminController', 'deleteSubject', ['admin']);
$router->addRoute('GET', '/admin/attendance', 'AdminController', 'attendance', ['admin']);
$router->addRoute('POST', '/admin/attendance/mark', 'AdminController', 'markAttendance', ['admin']);
$router->addRoute('GET', '/api/attendance/students', 'AdminController', 'getStudentsForAttendance');
$router->addRoute('GET', '/admin/exams', 'AdminController', 'exams', ['admin']);
$router->addRoute('POST', '/admin/exams/create', 'AdminController', 'createExam', ['admin']);
$router->addRoute('GET', '/admin/exams/edit/{id}', 'AdminController', 'editExam', ['admin']);
$router->addRoute('POST', '/admin/exams/edit/{id}', 'AdminController', 'editExam', ['admin']);
$router->addRoute('POST', '/admin/exams/delete/{id}', 'AdminController', 'deleteExam', ['admin']);
$router->addRoute('GET', '/admin/exams/results/{id}', 'AdminController', 'viewExamResults', ['admin']);
$router->addRoute('POST', '/admin/exams/results/{id}', 'AdminController', 'enterResults', ['admin']);
$router->addRoute('GET', '/admin/fees', 'AdminController', 'fees', ['admin']);
$router->addRoute('POST', '/admin/fees/collect', 'AdminController', 'collectFee', ['admin']);
$router->addRoute('GET', '/api/fees/student', 'AdminController', 'getStudentFeeDetails');
$router->addRoute('GET', '/admin/events', 'AdminController', 'events', ['admin']);
$router->addRoute('POST', '/admin/events/create', 'AdminController', 'createEvent', ['admin']);
$router->addRoute('GET', '/admin/events/edit/{id}', 'AdminController', 'editEvent', ['admin']);
$router->addRoute('POST', '/admin/events/edit/{id}', 'AdminController', 'editEvent', ['admin']);
$router->addRoute('POST', '/admin/events/delete/{id}', 'AdminController', 'deleteEvent', ['admin']);
$router->addRoute('GET', '/admin/gallery', 'AdminController', 'gallery', ['admin']);
$router->addRoute('POST', '/admin/gallery/upload', 'AdminController', 'uploadGalleryImage', ['admin']);
$router->addRoute('GET', '/admin/gallery/edit/{id}', 'AdminController', 'editGalleryImage', ['admin']);
$router->addRoute('POST', '/admin/gallery/edit/{id}', 'AdminController', 'editGalleryImage', ['admin']);
$router->addRoute('POST', '/admin/gallery/delete/{id}', 'AdminController', 'deleteGalleryImage', ['admin']);
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

// Parent routes
$router->addRoute('GET', '/parent/dashboard', 'ParentController', 'dashboard', ['parent']);
$router->addRoute('GET', '/parent/children', 'ParentController', 'children', ['parent']);
$router->addRoute('GET', '/parent/attendance', 'ParentController', 'attendance', ['parent']);
$router->addRoute('GET', '/parent/results', 'ParentController', 'results', ['parent']);
$router->addRoute('GET', '/parent/fees', 'ParentController', 'fees', ['parent']);

// API routes
$router->addRoute('GET', '/api/students', 'ApiController', 'getStudents');
$router->addRoute('GET', '/api/teachers', 'ApiController', 'getTeachers');
$router->addRoute('GET', '/api/classes', 'ApiController', 'getClasses');
$router->addRoute('GET', '/api/attendance', 'ApiController', 'getAttendance');
$router->addRoute('GET', '/api/fees', 'ApiController', 'getFees');
$router->addRoute('GET', '/api/subjects', 'ApiController', 'getSubjects');

// Handle request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);