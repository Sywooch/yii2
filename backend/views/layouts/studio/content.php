<?php

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\bootstrap\Nav;
?>
<div class="studio-content-wrapper">
    <section class="content-header">
        <div class="header-help pull-right"><i class="fa  fa-question-circle"></i> 帮助和服务</div>
        <?=Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);?>

        <?=Nav::widget([
            'items' => isset($this->params['nav']) ? $this->params['nav'] : [],
            'options' => ['class' =>'nav-pills']
        ]);?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>

    <section class="footer">
        <i class="glyphicon glyphicon-fire logo-image"></i> <?=Yii::$app->name;?>
    </section>

</div>
