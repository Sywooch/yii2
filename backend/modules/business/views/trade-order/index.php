<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradeOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trade Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trade Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'trade_no',
            'user_id',
            'product_id',
            'product_name',
            // 'picture_id',
            // 'picture_url:url',
            // 'sku_id',
            // 'sku_name',
            // 'price',
            // 'num',
            // 'subtotal',
            // 'activity_id',
            // 'discount',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
