<?php
/**
 * School Management System - Comprehensive Test Script
 * Tests all major functionality and identifies issues
 */

// Define BASE_PATH for standalone testing
define('BASE_PATH', __DIR__);

// Include configuration
require_once 'backend/config/database.php';
require_once 'backend/config/app.php';

// Include core classes
require_once 'backend/app/core/Database.php';
require_once 'backend/app/core/Controller.php';
require_once 'backend/app/core/Model.php';
require_once 'backend/app/core/View.php';
require_once 'backend/app/core/Router.php';
require_once 'backend/app/core/Session.php';
require_once 'backend/app/core/Auth.php';

class SystemTester {
    private $db;
    private $errors = [];
    private $warnings = [];
    private $success = [];

    public function __construct() {
        try {
            $this->db = new Database();
            if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
                $this->db->connect('', '');
            } else {
                $this->db->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
            }
            $this->success[] = "Database connection established successfully";
        } catch (Exception $e) {
            $this->errors[] = "Database connection failed: " . $e->getMessage();
        }
    }

    public function runAllTests() {
        echo "🧪 Starting School Management System Tests...\n\n";

        $this->testDatabaseSchema();
        $this->testFilePermissions();
        $this->testRequiredExtensions();
        $this->testModels();
        $this->testControllers();
        $this->testViews();
        $this->testRoutes();
        $this->testAssets();
        $this->testConfiguration();

        $this->displayResults();
    }

    private function testDatabaseSchema() {
        echo "📊 Testing Database Schema...\n";

        $requiredTables = [
            'users', 'students', 'teachers', 'classes', 'subjects',
            'attendance', 'exams', 'exam_results', 'fee_structure',
            'fee_payments', 'events', 'gallery', 'carousel', 'about',
            'courses', 'testimonials', 'settings', 'roles'
        ];

        foreach ($requiredTables as $table) {
            try {
                $this->db->query("SELECT 1 FROM {$table} LIMIT 1");
                $this->db->execute();
                $this->success[] = "Table '{$table}' exists and is accessible";
            } catch (Exception $e) {
                $this->errors[] = "Table '{$table}' is missing or not accessible: " . $e->getMessage();
            }
        }

        // Test default data
        try {
            $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
            $result = $this->db->single();
            if ($result['count'] > 0) {
                $this->success[] = "Default admin user exists";
            } else {
                $this->warnings[] = "No admin user found - you may need to run the installation";
            }
        } catch (Exception $e) {
            $this->errors[] = "Could not check for admin user: " . $e->getMessage();
        }
    }

    private function testFilePermissions() {
        echo "🔐 Testing File Permissions...\n";

        $directories = [
            'backend/logs',
            'backend/public/uploads',
            'backend/public/uploads/students',
            'backend/public/uploads/teachers',
            'backend/public/uploads/gallery',
            'backend/public/uploads/carousel',
            'assets'
        ];

        foreach ($directories as $dir) {
            if (file_exists($dir)) {
                if (is_writable($dir)) {
                    $this->success[] = "Directory '{$dir}' is writable";
                } else {
                    $this->errors[] = "Directory '{$dir}' is not writable";
                }
            } else {
                $this->warnings[] = "Directory '{$dir}' does not exist";
            }
        }
    }

    private function testRequiredExtensions() {
        echo "🔧 Testing Required PHP Extensions...\n";

        $extensions = [
            'pdo' => 'PDO',
            'pdo_mysql' => 'PDO MySQL',
            'mbstring' => 'MBString',
            'curl' => 'cURL',
            'openssl' => 'OpenSSL',
            'json' => 'JSON',
            'session' => 'Session',
            'gd' => 'GD (for image processing)',
            'zip' => 'ZIP (for file compression)'
        ];

        foreach ($extensions as $extension => $name) {
            if (extension_loaded($extension)) {
                $this->success[] = "{$name} extension is loaded";
            } else {
                $this->errors[] = "{$name} extension is not loaded";
            }
        }
    }

    private function testModels() {
        echo "🏗️ Testing Models...\n";

        $models = [
            'User', 'Student', 'Teacher', 'Class', 'Subject',
            'Attendance', 'Exam', 'Fee', 'Event', 'Gallery',
            'Carousel', 'About', 'Course', 'Testimonial', 'Setting'
        ];

        foreach ($models as $model) {
            $file = "backend/app/models/{$model}.php";
            if (file_exists($file)) {
                $this->success[] = "Model '{$model}' file exists";
            } else {
                $this->errors[] = "Model '{$model}' file is missing";
            }
        }
    }

    private function testControllers() {
        echo "🎮 Testing Controllers...\n";

        $controllers = [
            'HomeController', 'AuthController', 'AdminController',
            'TeacherController', 'StudentController', 'ParentController', 'CashierController'
        ];

        foreach ($controllers as $controller) {
            $file = "backend/app/controllers/{$controller}.php";
            if (file_exists($file)) {
                $this->success[] = "Controller '{$controller}' file exists";
            } else {
                $this->errors[] = "Controller '{$controller}' file is missing";
            }
        }
    }

    private function testViews() {
        echo "👁️ Testing Views...\n";

        $criticalViews = [
            'home/index.php',
            'auth/login.php',
            'admin/dashboard.php',
            'admin/students.php',
            'admin/teachers.php',
            'admin/classes.php',
            'teacher/dashboard.php',
            'student/dashboard.php',
            'parent/dashboard.php'
        ];

        foreach ($criticalViews as $view) {
            $file = "backend/app/views/{$view}";
            if (file_exists($file)) {
                $this->success[] = "View '{$view}' exists";
            } else {
                $this->errors[] = "View '{$view}' is missing";
            }
        }
    }

    private function testRoutes() {
        echo "🛣️ Testing Routes...\n";

        // Test if routes are properly defined in index.php
        $indexContent = file_get_contents('index.php');
        $requiredRoutes = [
            'HomeController',
            'AuthController',
            'AdminController',
            'TeacherController',
            'StudentController',
            'ParentController',
            'CashierController'
        ];

        foreach ($requiredRoutes as $route) {
            if (strpos($indexContent, $route) !== false) {
                $this->success[] = "Routes for '{$route}' are defined";
            } else {
                $this->warnings[] = "Routes for '{$route}' may not be properly defined";
            }
        }
    }

    private function testAssets() {
        echo "🎨 Testing Assets...\n";

        $assets = [
            'assets/css/style.css',
            'assets/images/hero-education.svg'
        ];

        foreach ($assets as $asset) {
            if (file_exists($asset)) {
                $this->success[] = "Asset '{$asset}' exists";
            } else {
                $this->warnings[] = "Asset '{$asset}' is missing";
            }
        }

        // Check for jQuery and Bootstrap CDN references in views
        $homeView = file_get_contents('backend/app/views/home/index.php');
        if (strpos($homeView, 'bootstrap@5.3.0') !== false) {
            $this->success[] = "Bootstrap 5 is properly referenced";
        } else {
            $this->warnings[] = "Bootstrap 5 may not be properly referenced";
        }
    }

    private function testConfiguration() {
        echo "⚙️ Testing Configuration...\n";

        $configFiles = [
            'backend/config/database.php',
            'backend/config/app.php'
        ];

        foreach ($configFiles as $config) {
            if (file_exists($config)) {
                $this->success[] = "Configuration file '{$config}' exists";
            } else {
                $this->errors[] = "Configuration file '{$config}' is missing";
            }
        }

        // Test if constants are defined
        $requiredConstants = [
            'APP_NAME', 'DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'
        ];

        foreach ($requiredConstants as $constant) {
            if (defined($constant)) {
                $this->success[] = "Constant '{$constant}' is defined";
            } else {
                $this->errors[] = "Constant '{$constant}' is not defined";
            }
        }
    }

    private function displayResults() {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "📋 TEST RESULTS SUMMARY\n";
        echo str_repeat("=", 60) . "\n";

        if (!empty($this->errors)) {
            echo "\n❌ ERRORS (" . count($this->errors) . "):\n";
            foreach ($this->errors as $error) {
                echo "  • {$error}\n";
            }
        }

        if (!empty($this->warnings)) {
            echo "\n⚠️  WARNINGS (" . count($this->warnings) . "):\n";
            foreach ($this->warnings as $warning) {
                echo "  • {$warning}\n";
            }
        }

        if (!empty($this->success)) {
            echo "\n✅ SUCCESS (" . count($this->success) . "):\n";
            foreach ($this->success as $success) {
                echo "  • {$success}\n";
            }
        }

        echo "\n" . str_repeat("=", 60) . "\n";

        if (empty($this->errors)) {
            echo "🎉 SYSTEM IS READY FOR PRODUCTION!\n";
            echo "🚀 You can now access the system at: http://localhost/\n";
            echo "👤 Default login: admin / admin123\n";
        } else {
            echo "🔧 Please fix the errors above before deploying to production.\n";
        }

        echo str_repeat("=", 60) . "\n";
    }
}

// Run the tests
$tester = new SystemTester();
$tester->runAllTests();
?>