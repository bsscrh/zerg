<?php

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User;

class UserToken extends Token
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
            $loginFail = array_key_exists('errcode', $wxresult);
            if ($loginFail) {
                $this->processLoginError($wxresult);
            }
            else {
                return $this->grantToken($wxresult);
            }
        }
    }

    // 处理微信登陆异常
    // 那些异常应该返回客户端，那些异常不应该返回客户端
    // 需要认真思考
    private function processLoginError($wxResult)
    {
        throw new WeChatException(
            [
                'msg' => $wxResult['errmsg'],
                'errorCode' => $wxResult['errcode']
            ]);
    }

    // 颁发令牌
    private function grantToken($wxResult)
    {
        $openid = $wxResult['openid'];

        $user = User::getByOpenID($openid);
        if (!$user)
        {
            $uid = $this->newUser($openid);
        }
        else {
            $uid = $user->id;
        }
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);

        return $token;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    // 写入缓存并返回token，后期可以通过token获取用户信息
    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $result = cache($key, $value, $expire_in);

        if (!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    // 创建新用户
    private function newUser($openid)
    {

        $user = User::create(
            [
                'openid' => $openid
            ]);
        return $user->id;
    }
}