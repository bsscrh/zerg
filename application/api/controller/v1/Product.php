<?php

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductMissException;
use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    public function getRecent($count=15) {
        (new Count())->goCheck();
        $product = ProductModel::getMostRecent($count);
        if($product->isEmpty()){
            throw new ProductMissException();
        }
        $product = $product->hidden(['summary']);
        return $product;
    }

    public function getAllInCategory($id){
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getAllInCategory($id);
        if($product->isEmpty()){
            throw new ProductMissException();
        }
        return $product;
    }

    public function getOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $detail = ProductModel::getProductDetail($id);
        if(!$detail){
            throw new ProductMissException();
        }
        return $detail;
    }
}
