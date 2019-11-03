<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value, $data) {
    	if($data['from'] == 1) {
    		$img_prefix = config('setting.img_prefix');
			$url = $img_prefix.$value;
			return $url;
    	}
    	return $value;
    }

    protected function articleImg($value,$flag){
    	if($flag == "newsDetail") {
    		$value = "../".$value;
    	}
    	return $value;
    }
}
