<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%trade}}".
 *
 * @property integer $id
 * @property string $trade_no
 * @property integer $user_id
 * @property integer $trade_status
 * @property integer $payment_id
 * @property integer $payment_status
 * @property integer $distribution_status
 * @property string $total_amount
 * @property string $paid_amount
 * @property string $balance_amount
 * @property string $discount_amount
 * @property string $distribution_amount
 * @property string $point_amount
 * @property string $refund_amount
 * @property integer $earn_point
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_address
 * @property string $contact_postcode
 * @property string $user_remark
 * @property integer $cancel_reason
 * @property integer $paid_at
 * @property integer $rated_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Trade extends \yii\db\ActiveRecord
{
    const TRADE_WAIT_PAY = 1;
    const TRADE_HAS_PAID = 2;
    const TRADE_HAS_CANCEL = 3;
    const TRADE_IS_DOING = 4;
    const TRADE_HAS_REFUND = 5;
    const TRADE_HAS_COMPLETE = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trade}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'trade_status', 'payment_id', 'payment_status', 'distribution_status', 'earn_point', 'cancel_reason', 'paid_at', 'rated_at', 'created_at', 'updated_at'], 'integer'],
            [['trade_status', 'payment_id', 'payment_status', 'user_remark', 'created_at', 'updated_at'], 'required'],
            [['total_amount', 'paid_amount', 'balance_amount', 'discount_amount', 'distribution_amount', 'point_amount', 'refund_amount'], 'number'],
            [['user_remark'], 'string'],
            [['trade_no'], 'string', 'max' => 32],
            [['contact_name'], 'string', 'max' => 64],
            [['contact_phone', 'contact_postcode'], 'string', 'max' => 16],
            [['contact_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_no' => '订单编号',
            'user_id' => 'User ID',
            'trade_status' => '交易状态', //1待付款，2已付款，3已取消，4退款中，5已退款，6已完成
            'payment_id' => '支付凭证编号',
            'payment_status' => '支付状态', //1未支付，2已支付, 3支付异常
            'distribution_status' => '配送状态',
            'total_amount' => '商品总金额',
            'paid_amount' => '已付金额',
            'balance_amount' => '余额支付金额',
            'discount_amount' => '优惠金额',
            'distribution_amount' => '配送费用',
            'point_amount' => '积分抵用金额',
            'refund_amount' => '退款金额',
            'earn_point' => '获得积分',
            'contact_name' => '收货人姓名',
            'contact_phone' => '收货人手机号',
            'contact_address' => '收货人地址',
            'contact_postcode' => '收货人邮编',
            'user_remark' => '客户备注',
            'cancel_reason' => '取消原因',
            'paid_at' => '支付成功时间',
            'rated_at' => '评价时间',
            'created_at' => '交易创建时间',
            'updated_at' => '订单修改时间',
        ];
    }

    public function getTradeStatusOptions($trade_status = null)
    {
        $arr = [
            self::TRADE_WAIT_PAY => '待付款',
            self::TRADE_HAS_PAID => '已付款',
            self::TRADE_HAS_CANCEL => '已取消',
            self::TRADE_IS_DOING => '处理中',
            self::TRADE_HAS_REFUND => '已退款',
            self::TRADE_HAS_COMPLETE => '已完成',
        ];
        if( $trade_status === null ){
            return $arr;
        }else{
            return isset($arr[$trade_status]) ? $arr[$trade_status] : $trade_status;
        }
    }

    public function getPaymentStatusOptions($trade_status = null)
    {
        $arr = [
            self::PAYMENT_WAIT_PAY => '待付款',
            self::PAYMENT_HAS_PAID => '已付款',
            self::PAYMENT_HAS_CANCEL => '已取消',
            self::PAYMENT_IS_DOING => '处理中',
            self::PAYMENT_HAS_REFUND => '已退款',
            self::PAYMENT_HAS_COMPLETE => '已完成',
        ];
        if( $trade_status === null ){
            return $arr;
        }else{
            return isset($arr[$trade_status]) ? $arr[$trade_status] : $trade_status;
        }
    }
}
