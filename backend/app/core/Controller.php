<?php
/**
 * Base Controller Class
 * All controllers should extend this class
 */

class Controller {
    protected $db;
    protected $auth;
    protected $data = [];

    public function __construct($db = null, $auth = null) {
        $this->db = $db;
        $this->auth = $auth;
    }

    public function model($model) {
        // Handle model name variations
        $modelFile = $model . '.php';
        $modelPath = BACKEND_PATH . '/app/models/' . $modelFile;

        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model($this->db);
        } else {
            die('Model does not exist: ' . $model);
        }
    }

    public function view($view, $data = []) {
        $viewFile = '../app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('View does not exist: ' . $view);
        }
    }

    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function setData($key, $value) {
        $this->data[$key] = $value;
    }

    public function getData($key = null) {
        if ($key) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }
        return $this->data;
    }
}