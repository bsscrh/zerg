<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/4/18
 * Time: 5:15
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 获取http传入的参数
        // 对这些参数做检验
        $request = Request::instance();
        $params = $request->param();

        //check()是默认要用的验证方法
        $result = $this->batch()->check($params);
        if(!$result){
            $exception = new ParameterException(
                [
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]
            );
            throw $exception;
        }
        else{
            return true;
        }
    }
}