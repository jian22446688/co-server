<?php
// +----------------------------------------------------------------------
// | TcPrism [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 Tangchao All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tangchao <79300975@qq.com>
// +----------------------------------------------------------------------
namespace plugins\tc_user;
use cmf\lib\Plugin;
use think\Db;
use app\portal\model\PortalPostModel;
use plugins\tc_user\model\PluginTcuserBuyModel;

class TcUserPlugin extends Plugin
{

    public $info = [
        'name'        => 'TcUser',
        'title'       => '用户增值服务',
        'description' => '用户增值服务',
        'status'      => 1,
        'author'      => 'Tangchao',
        'version'     => '1.1',
        'demo_url'    => 'http://www.songzhenjiang.cn',
        'author_url'  => 'http://www.songzhenjiang.cn'
    ];

    public $hasAdmin = 1;

    public function install()
    {
        //return true;
        if (tcuser_is_installed()) {
            return true;
        }
        $config=config('database');
        $sql = cmf_split_sql(PLUGINS_PATH . 'tc_user/data/tcuser.sql', $config['prefix'], $config['charset']);
        foreach ($sql as &$value) {Db::query($value);}
        @touch(PLUGINS_PATH . 'tc_user/data/install.lock');
        return true;
    }

    public function uninstall()
    {
        return true;
    }

    public function AfterContent($param)
    {

        $config = $this->getConfig();
        $data=[];
        $data['id']=$param['object_id'];

        if(empty($param['object']['more']['price'])){
            $data['price']=0;
        }else{
            $data['price']=$param['object']['more']['price'];
        }

        if(empty($param['object']['more']['show'])){
            $data['show']="";
        }else{
            $data['show']=$param['object']['more']['show'];
        }
        
        $data['reward']=$config['reward'];
        $userId=cmf_get_current_user_id();
        $w=[];
        $w['buy_ArticleID']=$data['id'];
        $w['buy_LogID']=$userId;
        $buy = PluginTcuserBuyModel::get($w);
        if(!empty($buy)){
            $data['isbuy']=1;
        }else{
            $data['isbuy']=0;
        }
        $this->assign("data",$data);
        echo $this->fetch('widget');
    }

    public function portalAdminArticleEditViewRightSidebar()
    {
        $request = request();
        $array=$request->param();
        $price="0";
        $show="";
        if(!empty($array['id'])){
            $post=PortalPostModel::get((int)$array['id']);
            if(!empty($post['more']['price'])) $price=$post['more']['price'];
            if(!empty($post['more']['show'])) $show=$post['more']['show'];
        }

        echo '<table class="table table-bordered"><tbody><tr><th><b>文章价格</b></th></tr>
        <tr><td><input class="form-control" type="text" name="post[more][price]" id="source" value="'.$price.'" placeholder="文章价格"></td></tr>';
        $config = $this->getConfig();
        if($config['show']==1){
            echo '<tr><th><b>隐藏内容</b></th></tr>
            <tr><td><input class="form-control" type="text" name="post[more][show]" id="source" value="'.$show.'" placeholder="隐藏内容"></td></tr>';
        }
        echo '</tbody></table>';
    }

    public function PortalAdminAfterSaveArticle($hookParam)
    {
        if(empty($hookParam['article']['more']['price'])) $hookParam['article']['more']['price']=0;
        if(empty($hookParam['article']['more']['show'])) $hookParam['article']['more']['show']='';
        $data=[];
        $data['id']=$hookParam['article']['id'];
        $data['more']['price']=(int)$hookParam['article']['more']['price'];
        $data['more']['show']=$hookParam['article']['more']['show'];
        Db::name("portal_post")->allowField(true)->isUpdate(true)->data($data, true)->save();
    }
}

function tcuser_is_installed()
{
    static $cmfIsInstalled;
    if (empty($cmfIsInstalled)) {
        $cmfIsInstalled = file_exists(PLUGINS_PATH . 'tc_user/data/install.lock');
    }
    return $cmfIsInstalled;
}