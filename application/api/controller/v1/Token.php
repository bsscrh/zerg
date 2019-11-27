<?php

namespace app\api\controller\v1;

use app\api\validate\TokenGet;
use app\api\service\UserToken;

class Token
{
    public function getToken($code = ''){
        (new TokenGet())->goCheck();

        $wx = new UserToken($code);
        $token = $wx->get();
        return [
            'token' => $token
        ];
    }

    public function curlTest(){
        echo curl_get('https://www.baidu.com');
    }
}