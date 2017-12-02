<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language'=>'zh-CN',
    'layout' => '@app/views/layouts/adminlte/main',
    'modules' => [
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
        'content' => [
            'class' => 'backend\modules\content\Module',
        ],
        'product' => [
            'class' => 'backend\modules\product\Module',
        ],
        'business' => [
            'class' => 'backend\modules\business\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'urlManager'=>array(
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => []
        ),
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            //'class' => 'yii\redis\Session',
            //'redis' => 'redis',
            'name' => 'advanced-backend', // this is the name of the session cookie used for login on the backend
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis', // Redis connection component or its config
            'channel' => 'queue', // Queue channel key
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-black-light',
                    //"skin-blue",
                    //"skin-black",
                    //"skin-red",
                    //"skin-yellow",
                    //"skin-purple",
                    //"skin-green",
                    //"skin-blue-light",
                    //"skin-black-light",
                    //"skin-red-light",
                    //"skin-yellow-light",
                    //"skin-purple-light",
                    //"skin-green-light"
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info','error', 'warning'],
                    'categories' => ['yii\db\Command::execute'],
                ],
//                [
//                    'class' => 'yii\log\DbTarget',
//                    'levels' => ['profile'],
//                    'logVars' => ['_POST'],
//                    'categories' => ['yii\db\Command::query'],
//                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
