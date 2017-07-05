<?php
namespace html5\controllers;

use yii;
use yii\web\Controller;
use html5\traits\RangerTrait;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    /**
     * AJAX API统一入口
     */
    public function actionApi()
    {
        $method = Yii::$app->request->post('method');
        $query = Yii::$app->request->post('query') != null? Yii::$app->request->post('query'):[];
        $params = Yii::$app->request->post('params') != null? Yii::$app->request->post('params'):[];
        $params['format'] = 'json';
        print_r(RangerTrait::api($method, $query, $params));
        Yii::$app->end();
    }

    /**
     * AJAX API测试
     */
    public function actionJavascript()
    {
        return $this->render('javascript');
    }
}