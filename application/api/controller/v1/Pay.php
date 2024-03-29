<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;
use app\api\service\WxNotify;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    //参数是order_id
    public function getPreOrder($id = ''){
        (new IDMustBePostiveInt())->goCheck();

        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify(){
        $notify = new WxNotify();
        //验证通过减库存
        $notify->Handle(new \WxPayConfig());
    }
}