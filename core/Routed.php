<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 18:04
 */

namespace jobtest\core;

class Routed
{

    static function routing()
    {
        // парсим из url контроллер и действие
        $controller_name = 'Site';
        $action_name = 'index';
        $routes = $_SERVER['REQUEST_URI'];
        if ($paramsIsSet = strpos($routes, '?')) {
            $routes = substr($routes, 0, $paramsIsSet);
        }
        $routes = explode('/', $routes);
        if (!empty($routes[1])) {
            $controller_name = self::getClassNameFromPartUrl($routes[1]);
            if (!empty($routes[2])) {
                $action_name = self::getClassNameFromPartUrl($routes[2]);
            }
        }
        /* подключаем файли с классом модели и классом контроллера
        P.S. имя файла модели совпадает с именем класа контролера
        P.P.S файла модели может и не быть*/
        $model_file = "models/" . $controller_name . '.php';
        if (file_exists($model_file)) {
            include $model_file;
        }
        $controller_file = "controllers/" . $controller_name . '.php';
        if (file_exists($controller_file)) {
            include_once $controller_file;
        } else {
            self::loadPage404();
        }
        // создаем контроллер и визиваем екшн
        $class = '\\' . 'jobtest\controllers' . '\\' . $controller_name;
        $controller = new $class($_REQUEST);
        $action = 'action' . $action_name;
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            self::loadPage404();
        }
    }

    private static function getClassNameFromPartUrl(string $url): string
    {
        $parts_url = explode('-', $url);
        $className = '';
        foreach ($parts_url as $part) {
            $className .= ucwords($part);
        }
        return $className;
    }

    static function loadPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}