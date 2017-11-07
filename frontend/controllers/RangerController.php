<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use frontend\traits\RangerTrait;

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
        $query = Yii::$app->request->post('query',[]);
        $params = Yii::$app->request->post('params',[]);
        return RangerTrait::api($method, $query, $params);
    }

    /**
     * AJAX API测试
     */
    public function actionJavascript()
    {
        return $this->render('javascript');
    }
}