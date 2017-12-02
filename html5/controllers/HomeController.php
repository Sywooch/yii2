<?php
namespace html5\controllers;

use yii\web\Controller;

/**
 * home controller
 */
class HomeController extends Controller
{
    public $layout = 'vcdiy';

    public function actionIndex()
    {
        return $this->render('index');
    }
}