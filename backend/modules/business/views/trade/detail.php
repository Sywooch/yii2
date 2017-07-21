<?php
    use yii\helpers\Html;
?>
<div class="kv-detail-content" style="padding:0px 50px;overflow:hidden">
    <h4>交易信息 <small><?=$model->trade_no;?></small></h4>
    <?php
    if(!empty($model->orders)){
        foreach($model->orders as $order){
    ?>
    <div class="row">
        <div class="col-sm-1">
            <div class="img-thumbnail img-rounded text-center">
                <?=Html::img('http://'.Yii::$app->params['domain']['image'].$order->picture->path,['width'=>'60','height'=>'60','style'=>'padding:2px;']);?>
                <div class="small text-muted">Published: 2016-04-01</div>
            </div>
        </div>
        <div class="col-sm-6">
            <table class="table table-bordered table-condensed table-hover small kv-table">
                <tbody>
                <tr class="danger">
                    <th colspan="6" class="text-center text-danger">订单信息</th>
                </tr>
                <tr class="active">
                    <th>#</th>
                    <th>订单号</th>
                    <th>商品</th>
                    <th>SKU</th>
                    <th class="text-right">单价</th>
                    <th class="text-right">数量</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?=$order->id; ?></td>
                    <td><?=$order->product_name; ?></td>
                    <td><?=$order->sku_name; ?></td>
                    <td class="text-right"><?=$order->price; ?></td>
                    <td class="text-right"><?=$order->num; ?></td>
                </tr>
                <tr class="warning">
                    <th></th>
                    <th>小计</th>
                    <th colspan="4" class="text-right">4,000.00</th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-5">
            <table class="table table-bordered table-condensed table-hover small kv-table">
                <tbody>
                <tr class="success">
                    <th colspan="6" class="text-center text-success">物流信息</th>
                </tr>
                <tr class="active">
                    <th>#</th>
                    <th>快递公司</th>
                    <th>快递单号</th>
                    <th>状态</th>
                    <th>收货人姓名</th>
                    <th class="text-right">收货人电话</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?=isset($order->logistical)?$order->logistical->logistical_name:'--'; ?></td>
                    <td><?=isset($order->logistical)?$order->logistical->logistical_no:'--'; ?></td>
                    <td><?=isset($order->logistical)?$order->logistical->logistical_status:''; ?></td>
                    <td><?=$model->contact_name; ?></td>
                    <td class="text-right"><?=$model->contact_phone; ?></td>
                </tr>
                <tr class="warning">
                    <th></th>
                    <th>收货人地址</th>
                    <th colspan="4" class="text-right"><?=$model->contact_address; ?></th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
        }
    }
    ?>
</div>
