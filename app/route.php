<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------

use think\Route;

/**
 * 自定义路由规则
 * 
 * restful api 开发api 版本控制
 */
Route::group('api/:version', function () {

    //Route::get('api/:version/', 'api/:version.Index/index');
    Route::get('/user/test', 'api/:version.Index/test');

    // routers token
    Route::group('/token', function (){
        Route::get('/login', 'api/:version.User/login');

        Route::get('/gettoken', 'api/:version.User/getToken');
        Route::post('/check', 'api/:version.User/checkToken');

    });

    // routers user
    Route::group('/user', function (){

        Route::post('/register', 'api/:version.Login/register');
        Route::post('/login', 'api/:version.Login/login');
        Route::get('/getUserInfo', 'api/:version.User/getUserInfo');
    });


});


if (file_exists(CMF_ROOT . "data/conf/route.php")) {
    $runtimeRoutes = include CMF_ROOT . "data/conf/route.php";
} else {
    $runtimeRoutes = [ ];
}

return $runtimeRoutes;