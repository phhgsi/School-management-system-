<?php
/**
 * School Management System - Test Script
 * Verifies system installation and functionality
 */

// Start session
session_start();

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>School Management System - Test Results</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }";
echo ".container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }";
echo ".test-item { margin: 15px 0; padding: 10px; border-radius: 5px; }";
echo ".pass { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }";
echo ".fail { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }";
echo ".warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }";
echo ".info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }";
echo "h1 { color: #333; text-align: center; }";
echo "h2 { color: #666; border-bottom: 1px solid #ddd; padding-bottom: 10px; }";
echo ".summary { background: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1>🏫 School Management System - Test Results</h1>";

$tests = [];
$passed = 0;
$failed = 0;
$warnings = 0;

// Test 1: PHP Version
$php_version = PHP_VERSION;
$tests[] = [
    'name' => 'PHP Version Check',
    'status' => version_compare($php_version, '8.1.0', '>=') ? 'pass' : 'fail',
    'message' => "PHP Version: $php_version (Required: >= 8.1.0)",
    'details' => version_compare($php_version, '8.1.0', '>=') ? '✓ PHP version is compatible' : '✗ PHP version is too old'
];

// Test 2: Required Extensions
$required_extensions = ['pdo', 'pdo_mysql', 'mbstring', 'curl', 'openssl', 'gd', 'zip'];
$extension_tests = [];

foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    $extension_tests[] = [
        'name' => ucfirst($ext) . ' Extension',
        'status' => $loaded ? 'pass' : 'fail',
        'message' => "$ext extension: " . ($loaded ? 'Loaded' : 'Not loaded'),
        'details' => $loaded ? "✓ $ext extension is available" : "✗ $ext extension is required but not loaded"
    ];
    if ($loaded) $passed++; else $failed++;
}

$tests = array_merge($tests, $extension_tests);

// Test 3: File Permissions
$directories = [
    'backend/logs',
    'backend/public/uploads',
    'assets/css',
    'assets/js'
];

$permission_tests = [];
foreach ($directories as $dir) {
    $is_writable = is_writable($dir);
    $permission_tests[] = [
        'name' => "Directory: $dir",
        'status' => $is_writable ? 'pass' : 'warning',
        'message' => "Write permission: " . ($is_writable ? 'OK' : 'Failed'),
        'details' => $is_writable ? "✓ $dir is writable" : "⚠ $dir is not writable - some features may not work"
    ];
    if ($is_writable) $passed++; else $warnings++;
}

$tests = array_merge($tests, $permission_tests);

// Test 4: Configuration Files
$config_tests = [];
$config_files = [
    'backend/config/database.php',
    'backend/config/app.php'
];

foreach ($config_files as $file) {
    $exists = file_exists($file);
    $config_tests[] = [
        'name' => "Config File: " . basename($file),
        'status' => $exists ? 'pass' : 'fail',
        'message' => "File exists: " . ($exists ? 'Yes' : 'No'),
        'details' => $exists ? "✓ $file is present" : "✗ $file is missing"
    ];
    if ($exists) $passed++; else $failed++;
}

$tests = array_merge($tests, $config_tests);

// Test 5: Database Connection (if configured)
$db_test = [];
if (file_exists('backend/config/database.php')) {
    try {
        // Include database config
        $db_config = include('backend/config/database.php');

        if (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER')) {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS ?? '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $db_test = [
                'name' => 'Database Connection',
                'status' => 'pass',
                'message' => 'Connection successful',
                'details' => '✓ Database connection established successfully'
            ];
            $passed++;
        } else {
            $db_test = [
                'name' => 'Database Configuration',
                'status' => 'warning',
                'message' => 'Database constants not defined',
                'details' => '⚠ Database configuration needs to be completed'
            ];
            $warnings++;
        }
    } catch (Exception $e) {
        $db_test = [
            'name' => 'Database Connection',
            'status' => 'fail',
            'message' => 'Connection failed',
            'details' => '✗ Database connection failed: ' . $e->getMessage()
        ];
        $failed++;
    }
} else {
    $db_test = [
        'name' => 'Database Configuration',
        'status' => 'warning',
        'message' => 'Configuration file missing',
        'details' => '⚠ Database configuration file not found'
    ];
    $warnings++;
}

$tests[] = $db_test;

// Display Results
echo "<div class='summary'>";
echo "<h2>Test Summary</h2>";
echo "<p>Total Tests: " . count($tests) . "</p>";
echo "<p style='color: green;'>Passed: $passed</p>";
echo "<p style='color: red;'>Failed: $failed</p>";
echo "<p style='color: orange;'>Warnings: $warnings</p>";
echo "</div>";

foreach ($tests as $test) {
    echo "<div class='test-item " . $test['status'] . "'>";
    echo "<h3>" . $test['name'] . "</h3>";
    echo "<p><strong>" . $test['message'] . "</strong></p>";
    echo "<p>" . $test['details'] . "</p>";
    echo "</div>";
}

// Recommendations
echo "<div class='test-item info'>";
echo "<h2>Next Steps</h2>";
echo "<ul>";
echo "<li>Run the web installer: <a href='install.php'>install.php</a></li>";
echo "<li>Access the homepage: <a href='index.php'>index.php</a></li>";
echo "<li>Login with default credentials (admin/admin123)</li>";
echo "<li>Customize school settings in the admin panel</li>";
echo "<li>Add students, teachers, and other data</li>";
echo "</ul>";
echo "</div>";

echo "<div class='test-item info'>";
echo "<h2>System Information</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "</div>";

echo "</div>";
echo "</body>";
echo "</html>";