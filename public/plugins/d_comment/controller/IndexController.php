<?php
// +----------------------------------------------------------------------
// | d_comment [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 DaliyCode All rights reserved.
// +----------------------------------------------------------------------
// | Author: DaliyCode <3471677985@qq.com> <author_url:dalicode.com>
// +----------------------------------------------------------------------
namespace plugins\d_comment\controller;

use app\admin\model\PluginModel;
use app\portal\model\PortalPostModel;
use app\user\model\CommentModel;
use cmf\controller\PluginBaseController;

class IndexController extends PluginBaseController {

    public function _initialize() {
        $where = ['status' => 1, 'name' => $this->getPlugin()->info['name']];
        $vo    = PluginModel::where($where)->cache(60, true)->find();
        if (!$vo) {
            $this->error('评论插件未启用！');
        }
    }

    public function add() {
        $config = $this->getPlugin()->getConfig();
        if (!$config || $config['comment_type'] == 2) {
            $this->error('评论已关闭！');
        }

        $userid = cmf_get_current_user_id();
        if ($userid) {
            $i = (int) $config['comment_interval'] >= 0 ? (int) $config['comment_interval'] : 5;
            if (session('com') && $i && (time() - session('com')) < $i) {
                $this->error('请' . $i . '秒后再评论！');
            }

            $data                = $this->request->param();
            $data['user_id']     = $userid;
            $data['more']        = $data['object_title'];
            $data['create_time'] = time();

            $config['comment_check'] == 1 && $data['status'] = 0;

            $c      = new CommentModel();
            $result = $c->validate(
                [
                    'object_id'  => 'number',
                    'table_name' => 'alphaDash',
                    'more'       => 'require',
                    'url'        => 'require',
                    'to_user_id' => 'number',
                    'parent_id'  => 'number',
                    'content'    => 'require',
                ],
                [
                    'content.require' => '评论内容不能为空',
                ]

            )->allowField(true)->isUpdate(false)->save($data);

            if (false === $result) {

                $this->error($c->getError());
            }

            session('com', time());
            PortalPostModel::where('id=' . $data['object_id'])->setInc('comment_count');
            $this->success("评论成功");

        } else {

            $this->error('请登录！');
        }
    }
}