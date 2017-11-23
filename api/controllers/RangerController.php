<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\components\ranger\RangerApi;
use yii\helpers\Inflector;
use api\components\RangerException;
use yii\helpers\ArrayHelper;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['http://m.yii2.com','http://www.yii2.com'],
                    'Access-Control-Allow-Credentials'=> true,
                ],
            ],
        ], parent::behaviors());
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function checkAccessToken($params)
    {
        if(!isset($params['query']['access_token']) || $params['query']['access_token'] == ''){
            RangerException::throwException(RangerException::APP_NEED_ACCESS_TOKEN,'',401);
        }
        $accessToken = $params['query']['access_token'];
        $userId = Yii::$app->cache->get($accessToken);
        if(!$userId){
            RangerException::throwException(RangerException::APP_ERROR_ACCESS_TOKEN,'',401);
        }
        $user = User::findOne($userId);
        $duration = 3600*24*30;
        Yii::$app->cache->set($accessToken, $userId, $duration);

        return $user->attributes;
    }

    public function generationQuery($model,$params)
    {
        $query = $model::find();
        if(isset($params['query']['where']) && is_array($params['query']['where']) && !empty($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->andWhere($where);
            }
        }
        return $query;
    }

    protected function execute($method, $version ,$params)
    {
        $key = $method.'#'.$version.'#'.md5(json_encode($params['query']));

        if($params['cache'] == true ) {
            if(Yii::$app->cache->exists($key)) {
                $result['data'] = json_decode(Yii::$app->cache->get($key),true);
            }else{
                $result['data'] = $this->implement($method, $version ,$params);
                Yii::$app->cache->set($key, json_encode($result['data']), $params['cache_time']);
            }
        } else {
            $result['data'] = $this->implement($method, $version ,$params);
        }
        return $result;
    }

    protected function implement($method, $version ,$params)
    {
        $method = explode('.',Inflector::camel2id($method));
        $common = ['user'];
        if(in_array($method[1], $common)){
            $modules = 'common';
        }else{
            $modules = 'v'.$version;
        }
        return Yii::$app->runAction($modules . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
    }

    // API 项目内调用接口
    public static function api($method, array $query, $params = [], $type='post')
    {
        $params['method'] = $method;
        $params['params'] = $query;

        $params['device'] = 'system';
        $params['device_id'] = '';
        $params['origin'] = 'api';

        $system = Yii::$app->params['system'];
        $params['key'] = $system[$params['origin']][$params['device']]['key'];
        $params['secret'] = $system[$params['origin']][$params['device']]['secret'];

        return RangerApi::request($params, $type);
    }
}