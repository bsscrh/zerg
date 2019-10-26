<?php

namespace app\api\model;

use think\Model;

class Banner extends Model
{
    protected $hidden = ['update_time','delete_time'];

    public function items(){
        //一个banner对应多个banneritem
        //第一个参数:被关联的模型.
        //第二个参数:被关联模型的外键(2个模型关联的字段).
        //第三个参数:当前模型的主键
        return $this->hasMany('BannerItem','banner_id','id');
    }
    public static function getBannerById($id) {
        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
}