<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;

//选择商品下单后，要检测库存量
//准备支付时，要检测库存量
//支付成功后，要检测库存量
class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    //下单
    public function placeOrder(){
        (New OrderPlace())->goCheck();
    }
}