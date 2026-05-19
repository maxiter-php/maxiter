<?php
/*
The ApiModel file configure the route for API in your project,
don't touch it =)

@author Victor Béser
*/
class ApiModel {

    private static $routes = array();
    private static $groupStack = array();

    public static function reset() {
        self::$routes = array();
        self::$groupStack = array();
    }

    public static function loadRoutesFromDirectory($directory) {
        if (!is_dir($directory)) {
            return;
        }

        $files = glob(rtrim($directory, "\\/") . DIRECTORY_SEPARATOR . '*.php');
        if ($files === false) {
            return;
        }

        sort($files);

        foreach ($files as $file) {
            require $file;
        }
    }

    public static function group($attributes, $callback) {
        self::$groupStack[] = is_array($attributes) ? $attributes : array();
        $callback();
        array_pop(self::$groupStack);
    }

    public static function prefix($prefix, $callback) {
        self::group(array('prefix' => $prefix), $callback);
    }

    public static function controller($controller, $callback) {
        self::group(array('controller' => $controller), $callback);
    }

    public static function middlewareGroup($middleware, $callback) {
        self::group(array('middleware' => $middleware), $callback);
    }

    public static function get($url, $action, $middleware = null) {
        self::addRoute(array('GET'), $url, $action, $middleware);
    }

    public static function post($url, $action, $middleware = null) {
        self::addRoute(array('POST'), $url, $action, $middleware);
    }

    public static function put($url, $action, $middleware = null) {
        self::addRoute(array('PUT'), $url, $action, $middleware);
    }

    public static function patch($url, $action, $middleware = null) {
        self::addRoute(array('PATCH'), $url, $action, $middleware);
    }

    public static function delete($url, $action, $middleware = null) {
        self::addRoute(array('DELETE'), $url, $action, $middleware);
    }

    public static function any($url, $action, $middleware = null) {
        self::addRoute(array('ANY'), $url, $action, $middleware);
    }

    public static function match($methods, $url, $action, $middleware = null) {
        self::addRoute($methods, $url, $action, $middleware);
    }

    public static function dispatch($urlParsed = null) {
        $requestPath = self::extractRequestPath($urlParsed);
        $requestMethod = strtoupper(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET');

        foreach (self::$routes as $route) {
            if (!self::matchesMethod($route['methods'], $requestMethod)) {
                continue;
            }

            $routeParameters = self::extractRouteParameters($route['url'], $requestPath);
            if ($routeParameters === false) {
                continue;
            }

            self::executeRoute($route, $routeParameters);
            return;
        }

        ResponseModel::json(false, "404 not found", 404);
    }

    public static function route($string, $url, $controller, $function, $middleware = null) {
        if (self::normalizePath($string) !== self::normalizePath($url)) {
            ResponseModel::json(false, "404 not found", 404);
        }

        $route = array(
            'methods' => array('ANY'),
            'url' => self::normalizePath($url),
            'action' => array(
                'controller' => $controller,
                'function' => $function ? $function : 'main',
            ),
            'middleware' => self::normalizeMiddleware($middleware),
        );

        self::executeRoute($route);
    }

    private static function addRoute($methods, $url, $action, $middleware = null) {
        $resolvedAction = self::resolveAction($action);

        self::$routes[] = array(
            'methods' => self::normalizeMethods($methods),
            'url' => self::buildRoutePath($url),
            'action' => $resolvedAction,
            'middleware' => self::mergeMiddleware($middleware),
        );
    }

    private static function executeRoute($route, $routeParameters = array()) {
        $controller = $route['action']['controller'];
        $function = $route['action']['function'];

        if (!$controller) {
            ResponseModel::json(false, "Route controller not defined", 500);
        }

        self::loadClassFile(__DIR__ . '/../controllers/' . $controller . '.php');

        foreach ($route['middleware'] as $middleware) {
            self::loadClassFile(__DIR__ . '/../middlewares/' . $middleware . '.php');

            if (!class_exists($middleware) || !$middleware::handle()) {
                ResponseModel::json(false, "Unauthorized", 401);
            }
        }

        if (!class_exists($controller)) {
            ResponseModel::json(false, "Controller not found", 500);
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $function)) {
            ResponseModel::json(false, "404 not found", 404);
        }

        ob_start();
        $result = self::invokeControllerAction($controllerInstance, $function, $routeParameters);
        $output = ob_get_clean();

        if ($output !== '') {
            echo $output;
            return;
        }

        ResponseModel::json(true, $result);
    }

    private static function invokeControllerAction($controllerInstance, $function, $routeParameters) {
        if (!class_exists('ReflectionMethod')) {
            return call_user_func_array(array($controllerInstance, $function), array_values($routeParameters));
        }

        $reflectionMethod = new ReflectionMethod($controllerInstance, $function);
        $arguments = array();

        foreach ($reflectionMethod->getParameters() as $parameter) {
            $parameterName = $parameter->getName();

            if (array_key_exists($parameterName, $routeParameters)) {
                $arguments[] = $routeParameters[$parameterName];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                ResponseModel::json(false, "Missing route parameter: " . $parameterName, 500);
            }
        }

        return $reflectionMethod->invokeArgs($controllerInstance, $arguments);
    }

    private static function resolveAction($action) {
        $controller = self::getCurrentController();
        $function = 'main';

        if (is_array($action)) {
            $controller = isset($action[0]) ? $action[0] : $controller;
            $function = isset($action[1]) && !empty($action[1]) ? $action[1] : $function;
        } elseif (is_string($action) && !empty($action)) {
            if ($controller) {
                $function = $action;
            } else {
                $controller = $action;
            }
        }

        return array(
            'controller' => $controller,
            'function' => $function,
        );
    }

    private static function mergeMiddleware($middleware = null) {
        $all = array();

        foreach (self::$groupStack as $group) {
            if (isset($group['middleware'])) {
                $all = array_merge($all, self::normalizeMiddleware($group['middleware']));
            }
        }

        if ($middleware !== null) {
            $all = array_merge($all, self::normalizeMiddleware($middleware));
        }

        return array_values(array_unique($all));
    }

    private static function normalizeMiddleware($middleware) {
        if ($middleware === null || $middleware === false || $middleware === '') {
            return array();
        }

        return is_array($middleware) ? array_values($middleware) : array($middleware);
    }

    private static function normalizeMethods($methods) {
        $methods = is_array($methods) ? $methods : array($methods);

        return array_map(function ($method) {
            return strtoupper($method);
        }, $methods);
    }

    private static function matchesMethod($routeMethods, $requestMethod) {
        return in_array('ANY', $routeMethods, true) || in_array($requestMethod, $routeMethods, true);
    }

    private static function buildRoutePath($url) {
        $prefix = '';

        foreach (self::$groupStack as $group) {
            if (isset($group['prefix']) && $group['prefix'] !== null) {
                $prefix .= '/' . trim($group['prefix'], '/');
            }
        }

        return self::normalizePath($prefix . '/' . trim($url, '/'));
    }

    private static function extractRequestPath($urlParsed) {
        $path = isset($urlParsed['path']) ? $urlParsed['path'] : '';
        $path = trim($path, '/');

        if ($path === 'api') {
            return '/';
        }

        if (strpos($path, 'api/') === 0) {
            $path = substr($path, 4);
        }

        return self::normalizePath($path);
    }

    private static function extractRouteParameters($routePath, $requestPath) {
        $routePath = self::normalizePath($routePath);
        $requestPath = self::normalizePath($requestPath);

        if (strpos($routePath, '{') === false) {
            return $routePath === $requestPath ? array() : false;
        }

        $parameterNames = array();
        $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', function ($matches) use (&$parameterNames) {
            $parameterNames[] = $matches[1];
            return '([^\./]+)';
        }, $routePath);

        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $requestPath, $matches)) {
            return false;
        }

        $parameters = array();

        foreach ($parameterNames as $index => $parameterName) {
            $parameters[$parameterName] = isset($matches[$index + 1]) ? urldecode($matches[$index + 1]) : null;
        }

        return $parameters;
    }

    private static function normalizePath($path) {
        $path = trim((string) $path);
        $path = trim($path, '/');

        if ($path === '') {
            return '/';
        }

        return '/' . $path;
    }

    private static function getCurrentController() {
        $controller = null;

        foreach (self::$groupStack as $group) {
            if (isset($group['controller']) && !empty($group['controller'])) {
                $controller = $group['controller'];
            }
        }

        return $controller;
    }

    private static function loadClassFile($path) {
        if (file_exists($path)) {
            require_once $path;
        }
    }

}
