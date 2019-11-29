<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\User;
use app\api\validate\AddressNew;
use app\api\service\Token;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;


class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress']
    ];

    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();

        $uid = Token::getCurrentUid();
        $user = User::get($uid);
        if(!$user){
            throw new UserException();
        }

        //只保存validate规则里面验证的数据，防止恶意传值
        $data = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save($data);
        }else{
            $user->address->save($data);
        }
        //使用json才能修改系统返回状态码
        return json(new SuccessMessage(),201);
    }
}