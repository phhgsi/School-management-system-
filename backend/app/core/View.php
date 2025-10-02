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
        $viewFile = BACKEND_PATH . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die('View does not exist: ' . $view);
        }

        $content = ob_get_clean();

        // Include layout if specified
        if ($this->layout) {
            $layoutFile = BACKEND_PATH . '/app/views/layouts/' . $this->layout . '.php';
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
        $partialFile = BACKEND_PATH . '/app/views/partials/' . $partial . '.php';
        if (file_exists($partialFile)) {
            include $partialFile;
        } else {
            die('Partial does not exist: ' . $partial);
        }
    }

    public function getData($key = null) {
        if ($key) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }
        return $this->data;
    }
}