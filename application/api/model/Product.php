<?php

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'];

    public function getMainImgUrlAttr($value){
    	return $this->getMainImgUrl($value);
    }
}
