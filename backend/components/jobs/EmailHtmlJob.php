<?php

namespace backend\components\jobs;

use Yii;
use yii\base\Object;
use yii\queue\Job;

class EmailHtmlJob extends Object implements Job
{
    public $to;
    public $subject;
    public $template;
    public $params;

    public function execute($queue)
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($this->to);
        $mail->setSubject($this->subject);
        $mail = Yii::$app->mailer->compose($this->template, $this->parmas);
        $mail->send();
    }
}