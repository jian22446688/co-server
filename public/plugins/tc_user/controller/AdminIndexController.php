<?php
// +----------------------------------------------------------------------
// | TcComment [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 Tangchao All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tangchao <79300975@qq.com>
// +----------------------------------------------------------------------
namespace plugins\tc_user\controller;

use think\Db;
use cmf\controller\PluginBaseController;
use plugins\tc_user\model\PluginTcuserCoinModel;

class AdminIndexController extends PluginBaseController
{

    function _initialize()
    {
        $adminId = cmf_get_current_admin_id();
        if (!empty($adminId)) {
            $this->assign("admin_id", $adminId);
        } else {
            $this->error('未登录');
        }
    }

    function coindel()
    {
        PluginTcuserCoinModel::destroy(['coin_user_IsUsed' => 1]);
        $this->success("删除成功！");
    }

    function coindeln()
    {
        PluginTcuserCoinModel::destroy(['coin_user_IsUsed' => 0]);
        $this->success("删除成功！");
    }

    function coinept()
    {
        PluginTcuserCoinModel::where('coin_ID','>',0)->delete();
        $this->success("删除成功！");
    }

    function index()
    {
        $r = new PluginTcuserCoinModel();
        $list  = $r->order('coin_user_IsUsed asc')->paginate(10);
        $page = $list->render();
        $this->assign('tccoin', $list);
        $this->assign('page', $page);
        return $this->fetch('/admin_index');
    }
    
    function Coin_CreateCode(){
        $p = $this->request->param('Coin', 0, 'intval');
        $n = $this->request->param('Number', 0, 'intval');
        $p=(int)$p;
        $n=(int)$n;
        if($n<1){$n=10;}
        if($p<1){$p=100;}
        for ($i=0; $i < $n; $i++) { 
            $r = new PluginTcuserCoinModel();
            $r->coin_InviteCode=TcUser_GetGuid();
            $r->coin_Coin=$p;
            $r->Save();
        }
        $this->success('生成成功');
    }
}

function TcUser_GetGuid() {
    $s = str_replace('.', '', trim(uniqid('yt', true), 'yt'));
    return $s;
}
