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
    // 只要调用登陆就颁发新令牌
    // 但旧的令牌依然可以使用
    // 所以通常令牌的有效时间比较短
    // 目前微信的express_in时间是7200秒
    // 在不设置刷新令牌（refresh_token）的情况下
    // 只能延迟自有token的过期时间超过7200秒（目前还无法确定，在express_in时间到期后
    // 还能否进行微信支付
    // 没有刷新令牌会有一个问题，就是用户的操作有可能会被突然中断
    private function grantToken($wxResult)
    {
        // 此处生成令牌使用的是TP5自带的令牌
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

    // 写入缓存
    private function saveToCache($wxResult)
    {
        $key = self::generateToken();
        $value = json_encode($wxResult);
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