<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-html5',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'html5\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-html5',
        ],
        'urlManager'=>array(
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => []
        ),
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'weibo' => [
                    'class' => 'common\components\clients\Weibo',
                    'clientId' => 'wb_key',
                    'clientSecret' => 'wb_secret',
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => 'github_appid',
                    'clientSecret' => 'github_appkey',
                ],
                'qq' => [
                    'class' => 'common\components\clients\QQ',
                    'clientId' => 'qq_appid',
                    'clientSecret' => 'qq_appkey',
                ],
                /*
                'wechat' => [
                    'class' => 'common\components\clients\WeChat',
                    'clientId' => 'weixin_appid',
                    'clientSecret' => 'weixin_appkey',
                ],
                */
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-html5', 'httpOnly' => true],
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => 'redis',
            'name' => 'advanced-html5',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
