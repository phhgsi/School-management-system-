<?php
/**
 * Database Connection Class
 * Handles MySQL database connections and queries
 */

class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $connection;
    private $stmt;

    public function __construct() {
        $this->connection = null;
        $this->stmt = null;
    }

    public function connect($host, $dbname, $username = '', $password = '') {
        // Check if using SQLite
        if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
            $this->connectSQLite();
        } else {
            $this->connectMySQL($host, $dbname, $username, $password);
        }
    }

    private function connectMySQL($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    private function connectSQLite() {
        $db_file = defined('DB_FILE') ? DB_FILE : BASE_PATH . '/database/school_management.db';

        try {
            $this->connection = new PDO("sqlite:$db_file");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Enable foreign key constraints for SQLite
            $this->connection->exec("PRAGMA foreign_keys = ON");
        } catch(PDOException $e) {
            throw new Exception("SQLite connection failed: " . $e->getMessage());
        }
    }

    public function query($sql) {
        $this->stmt = $this->connection->prepare($sql);
        return $this;
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function endTransaction() {
        return $this->connection->commit();
    }

    public function cancelTransaction() {
        return $this->connection->rollBack();
    }

    public function debugDumpParams() {
        return $this->stmt->debugDumpParams();
    }
}