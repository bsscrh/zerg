<?php

namespace app\api\model;

use think\Request;

class Wxnews extends BaseModel
{
    protected $autoWriteTimestamp = true; //开启自动时间戳,默认对create_time和update_time生效
    protected $createTime = 'create_time'; //创建时间字段
    protected $updateTime = 'update_time'; //更新时间字段
    protected $dateFormat = 'Y/m/d'; //时间字段取出后的默认时间格式

    public function getArticleImgAttr($value) {
    	$request = Request::instance();
    	$flag = "";
    	$url = $request->url();
    	//strpos返回第一次出现匹配的位置，所以要用false判断 !==false即存在
    	if(strpos($url, '/api/v1/wxnews/') !== false){
    		$flag = "newsDetail";
    	}
    	return $this->articleImg($value,$flag);
    }
}