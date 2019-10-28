<?php

namespace app\api\model;

class Theme extends BaseModel
{
    public function topicImg() {
    	return $this->belongsTo('Image','topic_img_id','id');
    }

    public function topImg() {
    	return $this->belongsTo('Image','head_img_id','id');
    }
}
