<?php

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\validate\AddressNew;
use app\api\service\Token;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
    public function createOrUpdateAddress(){
        (new AddressNew())->goCheck();
        $uid = Token::getCurrentUid();
        $user = User::get($uid);
        if(!$user){
            throw new UserException();
        }

        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save();
        }else{
            $user->address->save();
        }
        return new SuccessMessage();
    }
}