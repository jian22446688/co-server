<?php
// +----------------------------------------------------------------------
// | TcPrism [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 Tangchao All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tangchao <79300975@qq.com>
// +----------------------------------------------------------------------
namespace plugins\tc_user\controller;
use cmf\controller\PluginBaseController;
use plugins\tc_user\model\PluginTcuserCoinModel;
use plugins\tc_user\model\PluginTcuserBuyModel;
use plugins\tc_user\model\UserModel;
use app\portal\model\PortalPostModel;
use think\Db;

class IndexController extends PluginBaseController
{

    function addcoin()
    {
        return $this->fetch("/addcoin");
    }

    function tipcoin()
    {
        $coin = $this->request->param('coin', 0, 'intval');
        if($coin<1) $coin=1;
        $userId = cmf_get_current_user_id();
        if($userId){
            $user = UserModel::get($userId);
            if($user->coin>$coin){
                $user->coin=$user->coin-$coin;
                $user->Save();
                $userInfo = Db::name("user")->where('id', $userId)->find();
                cmf_update_current_user($userInfo);
                $this->success("打赏成功！".$user->coin);
            }else{
                $this->error('穷鬼，走开！！');
            }
        }else{
            $this->error('请登录账户！');
        }
    }

    function tip()
    {
       return $this->fetch("/tip");
    }

    function buy($id)
    {
        $post = PortalPostModel::get($id);
        if(empty($post->id)) $this->error('穷鬼，走开！！');
        if(empty($post['more']['price'])) $this->error('穷鬼，走开！！');
        $userId = cmf_get_current_user_id();

        $w=[];
        $w['buy_ArticleID']=$id;
        $w['buy_LogID']=$userId;
        $buy = PluginTcuserBuyModel::get($w);
        if(!empty($buy)) $this->error('已购买！！！');
        if($userId){
            $user = UserModel::get($userId);
            if($user->coin < $post['more']['price']){
                $this->error('穷鬼，走开！！');
            }else{
                $user->coin =$user->coin - $post['more']['price'];
                $user->Save();
                $buy= new PluginTcuserBuyModel();
                $buy->buy_OrderID = TcUser_GetGuid();
                $buy->buy_ArticleID = $id;
                $buy->buy_Pay = $post['more']['price'];
                $buy->buy_LogID = $userId;
                $buy->buy_PostTime = time();
                $buy->buy_IP = get_client_ip(0, true);
                $buy->Save();
                $this->success("购买成功！");
            }
        }else{
            $this->error('请登录账户！');
        }
    }

    function addcoin_post()
    {
        $coin = $this->request->param('coin', 0, 'intval');
        $r = PluginTcuserCoinModel::get(['coin_InviteCode' => $InviteCode]);
        if($r){
            if($r->coin_user_IsUsed) $this->error('充值卡已使用过');
            $userid=cmf_get_current_user_id();
            $user = UserModel::get($userid);
            $user->coin = $user->coin+$r->coin_Coin;
            $user->Save();
            $userInfo = Db::name("user")->where('id', $userid)->find();
            cmf_update_current_user($userInfo);
            $r->coin_user_id=$user->id;
            $r->coin_user_IsUsed=1;
            $r->Save();
            $this->success("充值成功！");
        }else{
            $this->error('充值卡错误！');
        }
    }

}

function TcUser_GetGuid() {
    $s = str_replace('.', '', trim(uniqid('yt', true), 'yt'));
    return $s;
}