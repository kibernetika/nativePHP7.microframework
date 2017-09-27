<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 26.09.2017
 * Time: 19:55
 */

namespace jobtest\controllers;

use jobtest\core\BaseController;

class Site extends BaseController
{

    function actionIndex()
    {
        $this->loadView('index', 'null');
    }

    function actionTest()
    {
        $this->loadView('test', 'null');
    }

}