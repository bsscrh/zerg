<?php

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'];

    public function imgs(){
        //第一个参数:被关联的模型.
        //第二个参数:被关联模型的外键(2个模型关联的字段).
        //第三个参数:当前模型的主键
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public function getMainImgUrlAttr($value, $data){
    	return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count){
        $product = self::limit($count)->order('create_time desc')->select();
        return $product;
    }

    public static function getAllInCategory($id){
        return self::where('category_id',$id)->select();
    }

    public static function getProductDetail($id){
        return self::with('imgs,properties')->find($id);
    }
}
