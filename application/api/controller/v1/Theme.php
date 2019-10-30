<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeMissException;

class Theme extends Controller
{
    public function getSimpleList($ids = '') {
    	(new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $imgs = ThemeModel::with('topicImg,topImg')->select($ids);
        if(!$imgs){
            throw new ThemeMissException();
        }
    	return $imgs;
    }
}
