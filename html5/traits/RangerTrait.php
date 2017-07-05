<?php
namespace html5\traits;

use yii;
use common\components\ranger\RangerApi;

Trait RangerTrait
{
    public static function api($method, array $query, $params = [], $type='post')
    {
        $params['method'] = $method;
        $params['params'] = $query;

        $params['key'] = Yii::$app->params['ranger.key'];
        $params['secret'] = Yii::$app->params['ranger.secret'];
        $params['device'] = 'computer';
        $params['device_id'] = '';
        $params['origin'] = 'html5';

        return RangerApi::request($params, $type);
    }
}