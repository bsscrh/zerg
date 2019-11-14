<?php

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Category as CategoryModel;
use app\lib\exception\BannerMissException;
use app\lib\exception\CategoryMissException;

class Category
{
    public function getCategories()
    {
//        $categories = CategoryModel::all([],'img');
        $categories = CategoryModel::with('img')->select();
        if($categories->isEmpty()){
            throw new CategoryMissException();
        }
        return $categories;
    }

}