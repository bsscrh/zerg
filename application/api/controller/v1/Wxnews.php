<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\model\Wxnews as WxnewsModel;
use think\Db;

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

    public function doSC($openid,$newsid){
        $map['openid']  = ['=',$openid];
        $map['newsid']  = ['=',$newsid];
        $ifsc=Db::table('wxnews_sc')->where($map)->find();
        if($ifsc){
            $id = $ifsc['id'];
            $res = DB::table('wxnews_sc')->where('id',$id)->delete();
            if ($res){
                return "cancel_sc";
            }
        }else{
            $res = DB::table('wxnews_sc')->data(['openid'=>$openid,'newsid'=>$newsid])->insert();
            if($res) {
                return "add_sc";
            }
        }
    }
}