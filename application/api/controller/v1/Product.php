<?php

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\lib\exception\ProductMissException;
use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    public function getRecent($count=15) {
        (new Count())->goCheck();
        $product = ProductModel::getMostRecent($count);
        if(!$product){
            throw new ProductMissException();
        }
        return $product;
    }
}
