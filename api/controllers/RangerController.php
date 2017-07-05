<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use common\components\ranger\RangerApi;
use yii\helpers\Inflector;
use api\components\RangerException;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    public $enableCsrfValidation = false;

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
        $method = explode('.',Inflector::camel2id($method));

        if($params['cache'] == true ) {
            if(Yii::$app->cache->exists($key)) {
                $result['data'] = Yii::$app->cache->get($key);
                $result['cache'] = $params['cache'];
            }else{
                $result['data'] = Yii::$app->runAction('/v' . $version . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
                Yii::$app->cache->set($key, $result['data'], $params['cache_time']);
                $result['cache'] = Yii::$app->params['cache'];
            }
        } else {
            $result['data'] = Yii::$app->runAction('/v' . $version . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
            $result['cache'] = Yii::$app->params['cache'];
        }
        return $result;
    }

    // API 项目内调用接口
    public static function api($method, array $query, $params = [], $type='post')
    {
        $params['method'] = $method;
        $params['params'] = $query;

        $params['key'] = Yii::$app->params['ranger.key'];
        $params['secret'] = Yii::$app->params['ranger.secret'];
        $params['device'] = 'system';
        $params['device_id'] = '';
        $params['origin'] = 'api';

        return RangerApi::request($params, $type);
    }
}