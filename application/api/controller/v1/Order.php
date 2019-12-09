<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token;
use app\api\service\Order as OrderService;

//选择商品下单后，要检测库存量
//准备支付时，要检测库存量
//支付成功后，要检测库存量
class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    //下单，参数是产品id和数量
    /*
     * {
        "products":[
            {"product_id":1,"count":2},
            {"product_id":2,"count":3}
            ]
        }
     * */
    public function placeOrder(){
        (New OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = Token::getCurrentUid();
        $order = new OrderService();
        $order = $order->place($uid, $products);
        return $order;
    }
}