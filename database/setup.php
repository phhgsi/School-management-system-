<?php
/**
 * Database Setup Script
 * Creates database and tables for School Management System
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'school_management';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Database '$database' created or already exists.\n";

    // Select the database
    $pdo->exec("USE `$database`");

    // Read and execute schema file
    $schemaFile = __DIR__ . '/schema.sql';
    if (file_exists($schemaFile)) {
        $schema = file_get_contents($schemaFile);

        // Split by semicolon to execute each statement
        $statements = array_filter(array_map('trim', explode(';', $schema)));

        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^(SET|USE|START|COMMIT)/i', $statement)) {
                try {
                    $pdo->exec($statement);
                } catch (PDOException $e) {
                    echo "Warning: " . $e->getMessage() . "\n";
                }
            }
        }

        echo "✓ Database schema created successfully.\n";
    } else {
        echo "✗ Schema file not found: $schemaFile\n";
        exit(1);
    }

    // Create directories for file uploads
    $uploadDirs = [
        __DIR__ . '/../backend/public/uploads',
        __DIR__ . '/../backend/public/uploads/students',
        __DIR__ . '/../backend/public/uploads/teachers',
        __DIR__ . '/../backend/public/uploads/gallery',
        __DIR__ . '/../backend/public/uploads/carousel',
        __DIR__ . '/../backend/logs'
    ];

    foreach ($uploadDirs as $dir) {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
            echo "✓ Created directory: $dir\n";
        }
    }

    // Set proper permissions
    foreach ($uploadDirs as $dir) {
        if (is_dir($dir)) {
            chmod($dir, 0755);
        }
    }

    echo "\n🎉 Database setup completed successfully!\n";
    echo "\n📋 Next steps:\n";
    echo "1. Update database configuration in backend/config/database.php\n";
    echo "2. Access the web interface at: http://localhost/\n";
    echo "3. Login with default credentials:\n";
    echo "   Username: admin\n";
    echo "   Password: admin123\n";
    echo "\n⚠️  Remember to change the default password after first login!\n";

} catch (PDOException $e) {
    echo "✗ Database setup failed: " . $e->getMessage() . "\n";
    exit(1);
}