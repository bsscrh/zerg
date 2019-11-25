<?php

use think\Route;

Route::get('api/:v/banner/:id', 'api/:v.Banner/getBanner');

Route::get('api/:v/theme', 'api/:v.Theme/getSimpleList');
Route::get('api/:v/theme/:id', 'api/:v.Theme/getComplexOne');

Route::get('api/:v/category/all', 'api/:v.Category/getCategories');

Route::get('api/:v/product/recent', 'api/:v.Product/getRecent');
Route::get('api/:v/product/by_category', 'api/:v.Product/getAllInCategory');

Route::post('api/:v/token/user', 'api/:v.Token/getToken');

Route::get('api/:v/wxnews', 'api/:v.Wxnews/getNewsList');
Route::get('api/:v/wxnews/:id', 'api/:v.Wxnews/getNewsDetail');
Route::get('api/:v/dosc/:openid/:newsid', 'api/:v.Wxnews/doSC');
