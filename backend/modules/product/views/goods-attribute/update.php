<?php


/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttribute */

$this->title = '创建SKU';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-globe"></i> SKU管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goods->name.' '.$model->attributeName->name.' '.$model->attributeValue->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="goods-attribute-update">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title pull-left"><?php echo $this->title;?></h3>
        </div>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
