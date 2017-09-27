<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 19:15
 */

namespace jobtest\core;


abstract class BaseController
{
    public $model;
    public $view;
    public $controller;
    public $request_params;

    function __construct(array $request_params)
    {
        $this->view = new BaseView();
        $this->request_params = $request_params;
    }

    function actionIndex()
    {
        echo 'It\'s default page';
    }

    function loadView($view, array $user_data = [])
    {
        $data = array_merge($this->request_params, $user_data);
        $controller = $this->getControllerName();
        $this->view->loadPage($view, $controller, $data);
    }

    function getControllerName(): string
    {
        $file_name = static::class;
        $controller_name = substr($file_name, strripos($file_name, '\\') + 1);
        return $controller_name;
    }

}