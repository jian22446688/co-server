<?php
// +----------------------------------------------------------------------
// | Author: heizai <876555425@qq.com>
// +----------------------------------------------------------------------
namespace plugins\hz_msg_borad;
use cmf\lib\Plugin;
use plugins\hz_msg_borad\model\PluginMessageModel;
class HzMsgBoradPlugin extends Plugin
{

	public $info = [
		'name'        => 'HzMsgBorad',//Demo插件英文名，改成你的插件英文就行了
		'title'       => '留言板',
		'description' => '留言板',
		'status'      => 1,
		'author'      => 'zc',
		'version'     => '1.0',
		'demo_url'    => '',
		'author_url'  => ''
	];

	public $hasAdmin = 1;//插件是否有后台管理界面

	// 插件安装
	public function install()
	{
		$model = new PluginMessageModel();
		$prefix = config('database.prefix');
		$sql = <<<sql
      CREATE TABLE `{$prefix}plugin_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '留言者姓名',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '留言者邮箱',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '留言者手机',
  `title` varchar(255) DEFAULT '' COMMENT '留言标题',
  `msg` text NOT NULL DEFAULT '' COMMENT '留言内容',
  `createtime` datetime NOT NULL COMMENT '留言时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表';
sql;
		$model->execute($sql);
		return true;//安装成功返回true，失败false
	}

	// 插件卸载
	public function uninstall()
	{
		$model = new PluginMessageModel();
		$prefix = config('database.prefix');
		$sql = <<<sql
		DROP  TABLE  {$prefix}plugin_guestbook;
sql;
		$model->execute($sql);
		return true;//卸载成功返回true，失败false
	}

	//实现的footer_start钩子方法
	public function guestbook($param)
	{
		$config = $this->getConfig();
		$this->assign($config);
		echo $this->fetch('widget');
	}

}