<?php

use think\Route;

Route::get('api/:v/banner/:id', 'api/:v.Banner/getBanner');

Route::get('api/:v/theme', 'api/:v.Theme/getSimpleList');
Route::get('api/:v/theme/:id', 'api/:v.Theme/getComplexOne');

Route::get('api/:v/category/all', 'api/:v.Category/getCategories');

Route::group('api/:v/product',function(){
    Route::get('/by_category', 'api/:v.Product/getAllInCategory');
    Route::get('/:id', 'api/:v.Product/getOne',[],['id'=>'\d+']);//id必须是正整数才能匹配该条路由，由于路由匹配是顺序匹配，如果不加id验证，下面的类似api/:v/product/recent就应该放在该条路由之前，否则会匹配不到。
    Route::get('/recent', 'api/:v.Product/getRecent');
});

Route::post('api/:v/token/user', 'api/:v.Token/getToken');
Route::get('api/:v/token/test', 'api/:v.Token/curlTest');

Route::post('api/:v/address', 'api/:v.Address/createOrUpdateAddress');

Route::post('api/:v/order', 'api/:v.Order/placeOrder');
Route::post('api/:v/pay/pre_order', 'api/:v.Pay/getPreOrder');

Route::get('api/:v/wxnews', 'api/:v.Wxnews/getNewsList');
Route::get('api/:v/wxnews/:id', 'api/:v.Wxnews/getNewsDetail');
Route::get('api/:v/dosc/:openid/:newsid', 'api/:v.Wxnews/doSC');



