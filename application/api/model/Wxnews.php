<?php

namespace app\api\model;

class Wxnews extends BaseModel
{
    protected $autoWriteTimestamp = true; //开启自动时间戳,默认对create_time和update_time生效
    protected $createTime = 'create_time'; //创建时间字段
    protected $updateTime = 'update_time'; //更新时间字段
    protected $dateFormat = 'Y/m/d'; //时间字段取出后的默认时间格式
}