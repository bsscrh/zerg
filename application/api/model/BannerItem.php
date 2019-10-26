<?php

namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];

    public function img(){
        //第一个参数:被关联的模型.
        //第二个参数:(2个模型关联的字段)被关联模型的外键.
        //第三个参数:当前模型的主键
        return $this->belongsTo('Image','img_id','id');
    }
}
