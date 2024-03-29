<?php
namespace app\lib\exception;
use think\Request;
use think\Exception;
use think\exception\Handle;
use think\Log;
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $err_code;
    public function render(\Exception $e)
    {
        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->err_code = $e->err_code;
        }else{
             //如果是服务器未处理的异常，将http状态码设置为500，并记录日志
            if(config('app_debug')){
                // 调试状态下需要显示TP默认的异常页面，因为TP的默认页面
                // 很容易看出问题
                return parent::render($e);
            }
            $this->code = 500;
            $this->msg = 'sorry，we make a mistake. (^o^)Y';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }
        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'err_code' => $this->err_code,
            'request_url' => $request->url(),
        ];
        return json($result,$this->code);
    }

    /*
     * 将异常写入日志
     */
    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}