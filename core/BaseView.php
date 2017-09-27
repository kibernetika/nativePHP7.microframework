<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 19:16
 */

namespace jobtest\core;


class BaseView
{
    private $template;
    private $view;
    private $view_folder;

    function __construct()
    {
        //Макет по умолчанию
        $this->template = 'template';
    }

    function loadPage($view, $controller_name, $data = null)
    {
        $this->view = $view;
        $this->view_folder = $this->getViewFolderFromControllerName($controller_name);
        include 'views/' . $this->template . '.php';
    }

    function getViewFolderFromControllerName($controller_name): string
    {
        $view_folder = strtolower($controller_name[0]);
        for ($i = 1; $i < mb_strlen($controller_name, "UTF-8"); $i++) {
            $char = mb_substr($controller_name, $i, 1, "UTF-8");
            if (($char >= 'A') && ($char <= 'Z')) {
                $char .= '-' . strtolower($char);
            }
            $view_folder .= $char;
        }
        return $view_folder;
    }

}