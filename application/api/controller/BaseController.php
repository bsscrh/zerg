<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/3/5
 * Time: 17:59
 */

namespace app\api\controller;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    //用户才可以
    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }

    //用户管理员都可以
    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }

    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }
}