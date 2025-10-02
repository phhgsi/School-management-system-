<?php
/**
 * Web Installation Script
 * Sets up the School Management System via web interface
 */

// Start session
session_start();

// Check if already installed
if (file_exists('backend/config/installed.php')) {
    die('System is already installed. To reinstall, please delete backend/config/installed.php');
}

$step = $_GET['step'] ?? 1;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_requirements'])) {
        $step = 2;
    } elseif (isset($_POST['database_setup'])) {
        $step = 3;
        // Handle database setup
        $dbHost = $_POST['db_host'] ?? 'localhost';
        $dbName = $_POST['db_name'] ?? 'school_management';
        $dbUser = $_POST['db_user'] ?? 'root';
        $dbPass = $_POST['db_password'] ?? '';

        try {
            $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create database
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Select database
            $pdo->exec("USE `$dbName`");

            // Import schema
            $schema = file_get_contents('database/schema.sql');
            $statements = array_filter(array_map('trim', explode(';', $schema)));

            foreach ($statements as $statement) {
                if (!empty($statement) && !preg_match('/^(SET|USE|START|COMMIT)/i', $statement)) {
                    $pdo->exec($statement);
                }
            }

            // Save database config
            $config = "<?php\n";
            $config .= "define('DB_HOST', '$dbHost');\n";
            $config .= "define('DB_NAME', '$dbName');\n";
            $config .= "define('DB_USER', '$dbUser');\n";
            $config .= "define('DB_PASS', '$dbPass');\n";
            $config .= "define('DB_INSTALLED', true);\n";

            file_put_contents('backend/config/database.php', $config);

            $success = 'Database setup completed successfully!';
            $step = 4;

        } catch (Exception $e) {
            $error = 'Database setup failed: ' . $e->getMessage();
        }

    } elseif (isset($_POST['admin_setup'])) {
        $step = 4;
        // Handle admin setup
        $adminUsername = $_POST['admin_username'] ?? 'admin';
        $adminEmail = $_POST['admin_email'] ?? 'admin@school.com';
        $adminPassword = $_POST['admin_password'] ?? 'admin123';
        $schoolName = $_POST['school_name'] ?? 'Springfield International School';

        try {
            // Update database config with real credentials
            $dbConfig = file_get_contents('backend/config/database.php');
            $dbConfig = str_replace("define('DB_INSTALLED', true);", "define('DB_INSTALLED', true);\n", $dbConfig);
            file_put_contents('backend/config/database.php', $dbConfig);

            // Update app config
            $appConfig = file_get_contents('backend/config/app.php');
            $appConfig = preg_replace("/define\('SCHOOL_NAME', '.*'\);/", "define('SCHOOL_NAME', '$schoolName');", $appConfig);
            file_put_contents('backend/config/app.php', $appConfig);

            // Create installed flag
            file_put_contents('backend/config/installed.php', "<?php\n// Installation completed on " . date('Y-m-d H:i:s') . "\n");

            $success = 'Installation completed successfully!';
            $step = 5;

        } catch (Exception $e) {
            $error = 'Admin setup failed: ' . $e->getMessage();
        }
    }
}

function checkRequirements() {
    $requirements = [
        'PHP Version (>= 8.1)' => version_compare(PHP_VERSION, '8.1.0', '>='),
        'PDO Extension' => extension_loaded('pdo'),
        'PDO MySQL Extension' => extension_loaded('pdo_mysql'),
        'MBString Extension' => extension_loaded('mbstring'),
        'cURL Extension' => extension_loaded('curl'),
        'OpenSSL Extension' => extension_loaded('openssl'),
        'GD Extension' => extension_loaded('gd'),
        'ZIP Extension' => extension_loaded('zip'),
        'File Uploads' => ini_get('file_uploads'),
        'Upload Max Size (>= 5MB)' => (int)str_replace('M', '', ini_get('upload_max_filesize')) >= 5,
        'Post Max Size (>= 8MB)' => (int)str_replace('M', '', ini_get('post_max_size')) >= 8,
        'Max File Uploads (>= 20)' => (int)ini_get('max_file_uploads') >= 20,
    ];

    return $requirements;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System - Installation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 2.5em;
        }
        .header p {
            color: #666;
            margin: 10px 0 0 0;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            color: #666;
            font-weight: bold;
        }
        .step.active {
            background: #667eea;
            color: white;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a67d8;
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert.error {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }
        .alert.success {
            background: #c6f6d5;
            color: #276749;
            border: 1px solid #9ae6b4;
        }
        .requirements {
            margin: 20px 0;
        }
        .requirement {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .requirement .status {
            margin-left: auto;
            font-weight: bold;
        }
        .requirement .status.pass {
            color: #276749;
        }
        .requirement .status.fail {
            color: #c53030;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 SMS Installation</h1>
            <p>School Management System Setup Wizard</p>
        </div>

        <div class="step-indicator">
            <div class="step <?php echo $step >= 1 ? 'active' : ''; ?>">1</div>
            <div class="step <?php echo $step >= 2 ? 'active' : ''; ?>">2</div>
            <div class="step <?php echo $step >= 3 ? 'active' : ''; ?>">3</div>
            <div class="step <?php echo $step >= 4 ? 'active' : ''; ?>">4</div>
            <div class="step <?php echo $step >= 5 ? 'active' : ''; ?>">5</div>
        </div>

        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
            <h2>Welcome to School Management System</h2>
            <p>This wizard will guide you through the installation process. Please ensure you have:</p>
            <ul style="margin: 20px 0; padding-left: 20px;">
                <li>PHP 8.1 or higher</li>
                <li>MySQL 8.0 or higher</li>
                <li>Proper file permissions</li>
                <li>Database credentials</li>
            </ul>
            <form method="post">
                <button type="submit" name="check_requirements" class="btn">Start Installation</button>
            </form>

        <?php elseif ($step == 2): ?>
            <h2>System Requirements Check</h2>
            <div class="requirements">
                <?php foreach (checkRequirements() as $requirement => $passed): ?>
                    <div class="requirement">
                        <span><?php echo $requirement; ?></span>
                        <span class="status <?php echo $passed ? 'pass' : 'fail'; ?>">
                            <?php echo $passed ? '✓' : '✗'; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
            <form method="post">
                <button type="submit" name="continue" class="btn">Continue</button>
            </form>

        <?php elseif ($step == 3): ?>
            <h2>Database Configuration</h2>
            <form method="post">
                <div class="form-group">
                    <label for="db_host">Database Host:</label>
                    <input type="text" id="db_host" name="db_host" value="localhost" required>
                </div>
                <div class="form-group">
                    <label for="db_name">Database Name:</label>
                    <input type="text" id="db_name" name="db_name" value="school_management" required>
                </div>
                <div class="form-group">
                    <label for="db_user">Database Username:</label>
                    <input type="text" id="db_user" name="db_user" value="root" required>
                </div>
                <div class="form-group">
                    <label for="db_password">Database Password:</label>
                    <input type="password" id="db_password" name="db_password">
                </div>
                <button type="submit" name="database_setup" class="btn">Setup Database</button>
            </form>

        <?php elseif ($step == 4): ?>
            <h2>Administrator Setup</h2>
            <form method="post">
                <div class="form-group">
                    <label for="school_name">School Name:</label>
                    <input type="text" id="school_name" name="school_name" value="Springfield International School" required>
                </div>
                <div class="form-group">
                    <label for="admin_username">Admin Username:</label>
                    <input type="text" id="admin_username" name="admin_username" value="admin" required>
                </div>
                <div class="form-group">
                    <label for="admin_email">Admin Email:</label>
                    <input type="email" id="admin_email" name="admin_email" value="admin@school.com" required>
                </div>
                <div class="form-group">
                    <label for="admin_password">Admin Password:</label>
                    <input type="password" id="admin_password" name="admin_password" value="admin123" required>
                </div>
                <button type="submit" name="admin_setup" class="btn">Complete Installation</button>
            </form>

        <?php elseif ($step == 5): ?>
            <h2>Installation Complete!</h2>
            <p>🎉 Your School Management System has been successfully installed!</p>
            <div style="background: #f7fafc; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <h3>Default Login Credentials:</h3>
                <p><strong>Username:</strong> admin</p>
                <p><strong>Password:</strong> admin123</p>
                <p><strong>URL:</strong> <a href="/" target="_blank">http://localhost/</a></p>
            </div>
            <div style="background: #fed7d7; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #feb2b2;">
                <strong>⚠️ Security Notice:</strong> Please change the default password immediately after first login!
            </div>
            <a href="/" class="btn" style="display: inline-block; text-decoration: none;">Go to Homepage</a>
        <?php endif; ?>
    </div>
</body>
</html>