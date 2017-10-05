<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 19:16
 */

namespace jobtest\core;


/**
 * Class BaseView
 * @package jobtest\core
 */
class BaseView
{
    /**
     * @var string
     */
    private $template;
    /**
     * @var string
     */
    private $view;
    /**
     * @var string
     */
    private $view_folder;

    function __construct()
    {
        $this->template = 'template'; //name file of page template - now is template.php
    }

    /**
     * @param $view_name
     * @param string $controller_name
     * @param array $data
     */
    function loadViewFile(string $view_name, string $controller_name, array $data): void
    {
        $this->view = $view_name;
        $this->view_folder = $this->getViewFolderFromControllerName($controller_name);
        include 'views/' . $this->template . '.php';
    }

    /**
     * @param string $controller_name
     * @return string
     */
    function getViewFolderFromControllerName(string $controller_name): string
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