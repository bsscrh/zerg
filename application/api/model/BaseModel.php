<?php

namespace app\api\model;

use think\Model;
use think\Request;

class BaseModel extends Model
{
    protected $img_prefix;

    //tp5.0模型初始化是initialize(),控制器初始化是_initialize()
    //tp5.1控制器初始化是initialize()
    //tp5.1模型初始化 protected static function init()，还未用过
    public function initialize(){
        $this->img_prefix = config('setting.img_prefix');
    }

    protected function prefixImgUrl($value, $data) {
    	if($data['from'] == 1) {
			$url = $this->img_prefix.$value;
			return $url;
    	}
    	return $value;
    }

    protected function getMainImgUrl($value) {
        $url = $this->img_prefix.$value;
        return $url;
    }

    protected function articleImg($value,$flag){
    	if($flag == "newsDetail") {
    		$value = "../".$value;
    	}
    	return $value;
    }

    protected function getUrl(){
        $request = Request::instance();
        $url = $request->url();
        return $url;
    }
}
