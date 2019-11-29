<?php

namespace app\api\controller\v1;

use app\api\validate\AddressNew;
use app\api\service\Token;

class Address
{
    public function createOrUpdateAddress(){
        (new AddressNew())->goCheck();
        $uid = Token::getCurrentUid();
    }
}