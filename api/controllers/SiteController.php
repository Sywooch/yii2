<?php
namespace api\controllers;

use yii;
use api\components\RangerException;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends RangerController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public $start;
    public $end;

    public function actionIndex()
    {
        $method = Yii::$app->request->post('method');
        $version = explode('.',Yii::$app->request->post('version'));
        $version = $version[0];
        $params['query'] = Yii::$app->request->post('params');
        $params['query'] = empty($params['query'])?[]:$params['query'];

        $params['version'] = Yii::$app->request->post('version');
        $params['device'] = Yii::$app->request->post('device');
        $params['device_id'] = Yii::$app->request->post('device_id');
        $params['origin'] = Yii::$app->request->post('origin');
        $params['timestamp'] = Yii::$app->request->post('timestamp');
        $params['ip'] = Yii::$app->request->post('ip');
        $params['agent'] = Yii::$app->request->post('agent');
        $params['cache'] = (bool)Yii::$app->request->post('cache', Yii::$app->params['cache']);
        $params['cache_time'] = Yii::$app->request->post('cache_time', Yii::$app->params['cacheTime']);

        try {
            $data = parent::execute($method, $version ,$params);
            $result = [
                'status' => 'success',
                'code' => '0',
                'data' => $data['data'],
                'cache' => $params['cache'],
            ];
        } catch (RangerException $e) {
            $result = [
                'status' => 'error',
                'code' => $e->statusCode,
                'data' => $e->getMessage(),
                'cache' => $params['cache'],
            ];
        }
        return $result;
    }

    public function beforeAction($action)
    {
        $this->start = explode(' ',microtime());
        if(!Yii::$app->request->post('method')){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS);
        }
        if(!Yii::$app->request->post('sign')){
            RangerException::throwException(RangerException::SYS_EMPTY_SIGN,'',401);
        }
        $params = Yii::$app->request->post();
        $sign = $params['sign'];
        unset($params['sign']);
        if(isset(Yii::$app->params['device'][$params['device']][$params['origin']]) && Yii::$app->params['device'][$params['device']][$params['origin']]['key'] == $params['key']){
            $query['secret'] = Yii::$app->params['device'][$params['device']][$params['origin']]['secret'];
        }else{
            RangerException::throwException(RangerException::SYS_ERROR_SECRET,'',401);
        }
        if(!empty($params['params'])) {
            ksort($params['params']);
        }
        ksort($params);

        $query = http_build_query($params);
        if($sign === strtoupper(md5($query))) {
            return parent::beforeAction($action);
        }else{
            RangerException::throwException(RangerException::SYS_ERROR_SIGN,'',401);
        }
    }

    public function afterAction($action, $result)
    {
        $this->end = explode(' ',microtime());
        $time = $this->end[0]+$this->end[1]-($this->start[0]+$this->start[1]);
        $result['used'] = round($time, 3)."s";
        $params = Yii::$app->request->post();
        $format = ArrayHelper::getValue($params, 'format', 'json');
        \Yii::$app->response->format = $format;
        return $result;
    }

}
