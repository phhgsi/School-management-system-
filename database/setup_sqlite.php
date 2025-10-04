<?php
/**
 * SQLite Database Setup Script
 * Creates database and tables for School Management System
 */

// Database configuration
$db_file = __DIR__ . '/school_management.db';

try {
    // Create database file if not exists
    if (!file_exists($db_file)) {
        touch($db_file);
        echo "✓ Database file created: $db_file\n";
    }

    // Connect to SQLite database
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✓ Connected to SQLite database.\n";

    // Read and execute schema file
    $schemaFile = __DIR__ . '/schema_sqlite.sql';
    if (file_exists($schemaFile)) {
        $schema = file_get_contents($schemaFile);

        // Split by semicolon to execute each statement
        $statements = array_filter(array_map('trim', explode(';', $schema)));

        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^(INSERT|CREATE INDEX)/i', $statement)) {
                try {
                    $pdo->exec($statement);
                } catch (PDOException $e) {
                    echo "Warning: " . $e->getMessage() . "\n";
                }
            }
        }

        // Execute INSERT statements and CREATE INDEX statements separately
        foreach ($statements as $statement) {
            if (!empty($statement) && preg_match('/^(INSERT|CREATE INDEX)/i', $statement)) {
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

    // Set proper permissions
    chmod($db_file, 0644);
    echo "✓ Set database file permissions.\n";

    // Create directories for file uploads
    $uploadDirs = [
        __DIR__ . '/../backend/public/uploads',
        __DIR__ . '/../backend/public/uploads/students',
        __DIR__ . '/../backend/public/uploads/teachers',
        __DIR__ . '/../backend/public/uploads/gallery',
        __DIR__ . '/../backend/public/uploads/carousel',
        __DIR__ . '/../backend/public/uploads/courses',
        __DIR__ . '/../backend/public/uploads/about',
        __DIR__ . '/../backend/logs'
    ];

    foreach ($uploadDirs as $dir) {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
            echo "✓ Created directory: $dir\n";
        }
    }

    echo "\n🎉 SQLite database setup completed successfully!\n";
    echo "\n📋 Next steps:\n";
    echo "1. Access the web interface at: http://localhost/\n";
    echo "2. Login with default credentials:\n";
    echo "   Username: admin\n";
    echo "   Password: admin123\n";
    echo "\n⚠️  Remember to change the default password after first login!\n";

} catch (PDOException $e) {
    echo "✗ Database setup failed: " . $e->getMessage() . "\n";
    exit(1);
}