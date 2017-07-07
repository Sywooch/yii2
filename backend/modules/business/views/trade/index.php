<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trade', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'trade_no',
            'user_id',
            'trade_status',
            'payment_id',
            // 'payment_satus',
            // 'distribution_status',
            // 'total_amount',
            // 'paid_amount',
            // 'balance_amount',
            // 'discount_amount',
            // 'distribution_amount',
            // 'point_amount',
            // 'refund_amount',
            // 'earn_point',
            // 'contact_name',
            // 'contact_phone',
            // 'contact_address',
            // 'contact_postcode',
            // 'user_remark:ntext',
            // 'cancel_reason',
            // 'paid_at',
            // 'rated_at',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
