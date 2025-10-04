<?php
/**
 * Database Configuration
 */

// Database credentials - Using SQLite for development
define('DB_TYPE', 'sqlite');
define('DB_FILE', BASE_PATH . '/database/school_management.db');
define('DB_HOST', 'localhost');
define('DB_NAME', 'school_management');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATION', 'utf8mb4_unicode_ci');

// Database options
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_PERSISTENT => true
]);

// Table prefix (optional)
define('DB_PREFIX', 'sms_');

// Connection timeout
define('DB_TIMEOUT', 30);

// Enable query logging (set to false in production)
define('DB_LOG_QUERIES', true);

// Maximum connections (for connection pooling)
define('DB_MAX_CONNECTIONS', 10);