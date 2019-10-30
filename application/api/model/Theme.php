<?php

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['topic_img_id','head_img_id','update_time','delete_time'];

    public function topicImg() {
    	return $this->belongsTo('Image','topic_img_id','id');
    }

    public function topImg() {
    	return $this->belongsTo('Image','head_img_id','id');
    }

    public function products(){
        //多对多
        //第一个参数是关联的模型，第二个参数是中间表(第三个表)的表名
        //第三个参数是关联模型的关联id，第4个参数当前模型的关联id
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }
}
