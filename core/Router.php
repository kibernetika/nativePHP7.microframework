<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 18:04
 */

namespace jobtest\core;

/**
 * Class Routed
 * @package jobtest\core
 */
class Router
{

    public function route(): void
    {
        list($controller_name, $action_name) = $this->parseControllerAndActionFromURL();
        $this->includeFile("models/" . $controller_name . '.php');
        if (!$this->includeFile("controllers/" . $controller_name . '.php')) {
            $this->loadPage404();
        }
        $controller_class = '\\' . 'jobtest\controllers' . '\\' . $controller_name;
        $controller = new $controller_class($_REQUEST);
        $action = 'action' . $action_name;
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            $this->loadPage404();
        }
    }

    /**
     * @return array
     */
    private function parseControllerAndActionFromURL(): array
    {
        $controller_name = 'Site';
        $action_name = 'index';
        $routes = $_SERVER['REQUEST_URI'];
        $params_is_set = strpos($routes, '?');
        if ($params_is_set) {
            $routes = substr($routes, 0, $params_is_set);
        }
        $routes = explode('/', $routes);
        if (!empty($routes[1])) {
            $controller_name = $this->getClassNameFromUrl($routes[1]);
            if (!empty($routes[2])) {
                $action_name = $this->getClassNameFromUrl($routes[2]);
            }
        }
        return array($controller_name, $action_name);
    }

    /**
     * @param string $url
     * @return string
     */
    private function getClassNameFromUrl(string $url): string
    {
        $parts_url = explode('-', $url);
        $class_name = '';
        foreach ($parts_url as $part) {
            $class_name .= ucwords($part);
        }
        return $class_name;
    }

    /**
     * @param string $model_file
     * @return bool
     */
    private function includeFile(string $model_file): bool
    {
        if (file_exists($model_file)) {
            include_once $model_file;
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function loadPage404(): void
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
