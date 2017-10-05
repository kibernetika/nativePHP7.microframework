<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 19:15
 */

namespace jobtest\core;


/**
 * Class BaseController
 * @package jobtest\core
 */
abstract class BaseController
{
    /**
     * @var string
     */
    public $model;
    /**
     * @var string
     */
    public $view;
    /**
     * @var string
     */
    public $controller;
    /**
     * @var array
     */
    public $request_params;

    public function __construct(array $request_params)
    {
        $this->view = new BaseView();
        $this->request_params = $request_params;
    }

    public function actionIndex(): void
    {
        echo 'It\'s default page';
    }

    /**
     * @param string $view_name
     * @param array $user_data
     */
    public function loadView(string $view_name, array $user_data = []): void
    {
        $data = array_merge($this->request_params, $user_data);
        $controller = $this->getControllerName();
        $this->view->loadViewFile($view_name, $controller, $data);
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        $file_name = static::class;
        $controller_name = substr($file_name, strripos($file_name, '\\') + 1);
        return $controller_name;
    }

}
