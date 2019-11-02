<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeMissException;
use app\api\validate\IDMustBePostiveInt;

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

    public function getComplexOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        return $theme;
    }
}
