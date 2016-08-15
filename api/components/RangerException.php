<?php

namespace api\components;

use yii;
use yii\web\HttpException;

/**
 * This is the exception class for ranger.
 */
class RangerException extends \Exception
{
    const ERROR_CUSTOM = 10000;
    const EMPTY_SIGN = 10001;
    const ERROR_SIGN = 10002;
    const ERROR_SECRET = 10003;
    const ERROR_PARAMS = 10004;
    const EMPTY_RECORD = 10005;
    const ERROR_TOKEN = 10006;

    private function getExceptionMessage($code)
    {
        $messages = [
            self::EMPTY_SIGN => '该请求需要签名',
            self::ERROR_SIGN => '签名未通过验证',
            self::ERROR_SECRET => '获取秘钥失败',
            self::ERROR_PARAMS => '参数错误',
            self::EMPTY_RECORD => '查询记录为空',
            self::ERROR_TOKEN => '令牌已过期',
        ];
        if(isset($messages[$code])){
            return $messages[$code];
        }
        return '未知的错误';
    }

    public static function throwException($code, $message = '')
    {
        if($code != self::ERROR_CUSTOM){
            $message = self::getExceptionMessage($code).$message;
        }
        throw new HttpException('403',$message,$code);
    }
}