<?php

namespace common\components\jobs;

use Yii;
use yii\base\Object;
use yii\queue\Job;

class DownloadJob extends Object implements Job
{
    public $url;
    public $file;

    public function execute($queue)
    {
        file_put_contents($this->file, file_get_contents($this->url));
    }
}