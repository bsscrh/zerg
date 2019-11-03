<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\model\Wxnews as WxnewsModel;

class Wxnews extends Controller
{
    public function getNewsList(){
        $newsList = WxnewsModel::select();
        return $newsList;
    }

    public function getNewsDetail($id){
        $detail = WxnewsModel::find($id);
        return $detail;
    }
}