<?php

namespace common\components\ranger;

use yii;
use yii\helpers\ArrayHelper;

/**
 * This is the exception class for ranger.
 */
class RangerApi
{
    public static function request(array $params, $type = 'post')
    {
        $params['agent'] = Yii::$app->request->getUserAgent();
        $params['ip'] = Yii::$app->request->getUserHost();
        $params['timestamp'] = time();
        $params['version'] = ArrayHelper::getValue($params, 'version', '1.0');
        $params['format'] = ArrayHelper::getValue($params, 'format', 'json');
        
        $params['sign'] = self::generateSign($params);
        $params = http_build_query($params);
        $url = Yii::$app->params['domain']['api'];

        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, $type =='post'?1:0 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    
    public static function generateSign($params)
    {
        if(!empty($params['params'])) {
            ksort($params['params']);
        }
        ksort($params);

        $query = http_build_query($params);
        return strtoupper(md5($query));
    }
}