<?php
// +----------------------------------------------------------------------
// | Author: heizai <876555425@qq.com>
// +----------------------------------------------------------------------
namespace plugins\hz_msg_borad\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\hz_msg_borad\model\PluginMessageModel;
use think\Db;

class AdminIndexController extends PluginAdminBaseController
{

    protected function _initialize()
    {
        parent::_initialize();
        $adminId = cmf_get_current_admin_id();//获取后台管理员id，可判断是否登录
        if (!empty($adminId)) {
            $this->assign("admin_id", $adminId);
        }
    }

    /**
     * 留言列表
     * @adminMenu(
     *     'name'   => '留言列表',
     *     'parent' => 'admin/Plugin/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '演示插件',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $model = new PluginMessageModel();
        $datas = $model->order('id desc')->paginate();
        $this->assign("datas", $datas);
        $this->assign('page', $datas->render());
        return $this->fetch('/admin_index');
    }
}
