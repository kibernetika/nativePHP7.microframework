<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 19:55
 */

namespace jobtest\controllers;

use jobtest\core\BaseController;

/**
 * Class Site
 * @package jobtest\controllers
 */
class Site extends BaseController
{

    public function actionIndex(): void
    {
        $this->loadView('index', []);
    }

    public function actionTest(): void
    {
        $this->loadView('test', ['my_data' => 'test param']);
    }

}
