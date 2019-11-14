<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/8
 * Time: 22:38
 */

namespace app\lib\exception;


class ProductMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的product不存在';
    public $err_code = 20000;
}