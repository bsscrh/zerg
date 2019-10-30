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
}
