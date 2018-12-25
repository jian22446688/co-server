<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | 官网 http://www.thinkcmf.com
// +----------------------------------------------------------------------
// | 玩转ThinkCMF，欢迎关注ThinkCMF学院！
// +----------------------------------------------------------------------
// | Author: J&C
// +----------------------------------------------------------------------
// | 感谢：ThinkCMF平台 && 老猫
// +----------------------------------------------------------------------
namespace plugins\float_menu_lite;

use cmf\lib\Plugin;
use think\Db;

class FloatMenuLitePlugin extends Plugin
{

    public $info = [
        'name'        => 'FloatMenuLite',
        'title'       => '简约浮动菜单（自适应版）',
        'description' => '真正精简浮动菜单，自定义颜色，PC、移动端自动识别切换',
        'status'      => 1,
        'author'      => 'J&C',
        'version'     => '1.0'
    ];

    public $hasAdmin = 0;//插件是否有后台管理界面

    // 插件安装
    public function install()
    {
        return true;//安装成功返回true，失败false
    }

    // 插件卸载
    public function uninstall()
    {
        return true;//卸载成功返回true，失败false
    }

    public function beforeBodyEnd()
    {
		$config = $this->getConfig();
        $this->assign($config);
        $this->assign('isMobile',cmf_is_mobile());
        echo $this->fetch('widget');
    }

}