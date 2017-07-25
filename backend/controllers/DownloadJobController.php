<?php

namespace backend\controllers;

use Yii;
use common\components\jobs\DownloadJob;

/**
 * DownloadJobController
 */
class DownloadJobController extends Controller
{
    //加入队列
    public function actionIndex()
    {
        $id = Yii::$app->queue->push(new DownloadJob([
            'url' => 'http://example.com/image.jpg',
            'file' => '/job.jpg',
        ]));
    }
}