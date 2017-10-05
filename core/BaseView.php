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

    public function __construct()
    {
        $this->template = 'template'; //name file of page template - now is template.php
    }

    /**
     * @param $view_name
     * @param string $controller_name
     * @param array $data
     */
    public function loadViewFile(string $view_name, string $controller_name, array $data): void
    {
        $this->view = $view_name;
        $this->view_folder = $this->getViewFolder($controller_name);
        include 'views/' . $this->template . '.php';
    }

    /**
     * @param string $controller_name
     * @return string
     */
    public function getViewFolder(string $controller_name): string
    {
        $view_folder = strtolower($controller_name[0]);
        $length_controller_name = mb_strlen($controller_name, "UTF-8");
        for ($i = 1; $i < $length_controller_name; $i++) {
            $char = mb_substr($controller_name, $i, 1, "UTF-8");
            if (($char >= 'A') && ($char <= 'Z')) {
                $char .= '-' . strtolower($char);
            }
            $view_folder .= $char;
        }
        return $view_folder;
    }

}
