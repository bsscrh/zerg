<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\IDCollection;

class Theme extends Controller
{
    public function getSimpleList($ids = '') {
    	(new IDCollection())->goCheck();
    	return 'success';
    }
}
