<?php
/**
 * Router Class
 * Handles URL routing and controller method calling
 */

class Router {
    private $db;
    private $auth;
    private $routes = [];
    private $params = [];

    public function __construct($db, $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    public function addRoute($method, $url, $controller, $action, $roles = []) {
        $route = [
            'method' => $method,
            'url' => $url,
            'controller' => $controller,
            'action' => $action,
            'roles' => $roles
        ];

        $this->routes[] = $route;
    }

    public function dispatch($method, $uri) {
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'];

        // Remove query string from path
        $path = explode('?', $path)[0];

        // Remove trailing slash
        $path = rtrim($path, '/');

        // Set default path
        if (empty($path)) {
            $path = '/';
        }

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $method, $path)) {
                return $this->callController($route);
            }
        }

        // Route not found
        http_response_code(404);
        echo '404 - Page not found';
    }

    private function matchRoute($route, $method, $path) {
        if ($route['method'] !== $method) {
            return false;
        }

        $routePath = $route['url'];

        // Convert route pattern to regex
        $pattern = preg_replace('/\//', '\\/', $routePath);
        $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-zA-Z0-9-_]+)', $pattern);
        $pattern = '/^' . $pattern . '$/';

        if (preg_match($pattern, $path, $matches)) {
            // Extract parameters
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $this->params[$key] = $value;
                }
            }
            return true;
        }

        return false;
    }

    private function callController($route) {
        $controllerName = $route['controller'];
        $actionName = $route['action'];
        $roles = $route['roles'];

        // Check authentication and authorization
        if (!empty($roles) && !$this->auth->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }

        if (!empty($roles) && !$this->auth->hasRole($roles)) {
            http_response_code(403);
            echo '403 - Access forbidden';
            return;
        }

        // Include controller file
        $controllerFile = BACKEND_PATH . '/app/controllers/' . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            http_response_code(500);
            echo 'Controller not found: ' . $controllerName;
            return;
        }

        require_once $controllerFile;

        // Create controller instance
        $controller = new $controllerName($this->db, $this->auth);

        // Check if method exists
        if (!method_exists($controller, $actionName)) {
            http_response_code(500);
            echo 'Method not found: ' . $actionName;
            return;
        }

        // Call controller method
        call_user_func_array([$controller, $actionName], $this->params);
    }

    private function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function getParams() {
        return $this->params;
    }
}