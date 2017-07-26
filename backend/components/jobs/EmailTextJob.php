<?php

namespace backend\components\jobs;

use Yii;
use yii\base\Object;
use yii\queue\Job;

class EmailTextJob extends Object implements Job
{
    public $to;
    public $subject;
    public $htmlBody;

    public function execute($queue)
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($this->to);
        $mail->setSubject($this->subject);
        $mail->setHtmlBody($this->htmlBody);
        $mail->send();
    }
}