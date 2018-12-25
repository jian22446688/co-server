<?php
// +----------------------------------------------------------------------
// | Author: heizai <876555425@qq.com>
// +----------------------------------------------------------------------
namespace plugins\hz_msg_borad\controller;
use cmf\controller\PluginBaseController;
use plugins\hz_msg_borad\model\PluginMessageModel;
use think\Db;

class DoController extends PluginBaseController
{

    // 留言提交
    public function addmsg(){
        $model = new PluginMessageModel();
        $data = $this->request->post();
        $result = $this->validate($data, "Post");

        if ($result !== true) {
            $this->error($result);
        }
        if(!cmf_captcha_check($data['verify'])){
            $this->error("验证码错误！");
        }

        if ($this->request->isPost()) {
            $data['createtime'] = date('Y-m-d H:i:s');
            $result=$model->allowField(true)->save($data);
            if ($result!==false) {
                $this->success("留言成功！");
            } else {
                $this->error("留言失败！");
            }
        }

    }

}
