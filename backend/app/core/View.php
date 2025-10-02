<?php
/**
 * View Class
 * Handles template rendering and data passing
 */

class View {
    private $data = [];
    private $layout = 'default';

    public function __construct() {
        //
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function assign($key, $value) {
        $this->data[$key] = $value;
    }

    public function render($view, $data = []) {
        // Merge data
        $this->data = array_merge($this->data, $data);

        // Extract data for template
        extract($this->data);

        // Start output buffering
        ob_start();

        // Include view file
        $viewFile = BASE_PATH . '/backend/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception('View file not found: ' . $viewFile);
        }

        $content = ob_get_clean();

        // Include layout if specified
        if ($this->layout) {
            $layoutFile = BASE_PATH . '/backend/app/views/layouts/' . $this->layout . '.php';
            if (file_exists($layoutFile)) {
                ob_start();
                include $layoutFile;
                $content = ob_get_clean();
            }
        }

        echo $content;
    }

    public function partial($partial, $data = []) {
        // Merge data
        $partialData = array_merge($this->data, $data);

        // Extract data for partial
        extract($partialData);

        // Include partial file
        $partialFile = BASE_PATH . '/backend/app/views/partials/' . $partial . '.php';
        if (file_exists($partialFile)) {
            include $partialFile;
        } else {
            throw new Exception('Partial file not found: ' . $partialFile);
        }
    }

    public function getData($key = null) {
        if ($key) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }
        return $this->data;
    }
}