<?php

namespace app\api\service;


use think\Exception;

class UserToken
{
    protected $code;
    protected $appid;
    protected $secret;
    protected $loginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->appid = config('wx.appid');
        $this->secret = config('wx.secret');
        $this->loginUrl = sprintf(config('wx.login_url'),$this->appid,$this->secret,$this->code);
    }

    public function get(){
        $result = curl_get($this->loginUrl);
        $wxresult =  json_decode($result,true);
        if(empty($wxresult)){
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        }else{
            // 建议用明确的变量来表示是否成功
            // 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
            // 这样非常不好判断，只能使用errcode是否存在来判断
            $loginFail = array_key_exists('errcode', $wxresult);
            if ($loginFail) {
//                $this->processLoginError($wxresult);
            }
            else {
//                return $this->grantToken($wxresult);
            }
        }
    }
}