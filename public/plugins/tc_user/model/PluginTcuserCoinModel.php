<?php
// +----------------------------------------------------------------------
// | TcAd [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 Tangchao All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tangchao <79300975@qq.com>
// +----------------------------------------------------------------------
namespace plugins\tc_user\model;
use think\Model;

class PluginTcuserCoinModel extends Model
{
    public function user()
    {
        return $this->belongsTo('UserModel', 'coin_user_id')->setEagerlyType(1);
    }
}