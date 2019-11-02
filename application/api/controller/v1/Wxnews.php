<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\model\Wxnews as WxnewsModel;

class Wxnews extends Controller
{
    public function getNews(){
        $news = WxnewsModel::select();
        return $news;
    }
}