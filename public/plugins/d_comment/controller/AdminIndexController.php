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
use cmf\controller\PluginBaseController;
use think\Db;

class AdminIndexController extends PluginBaseController {

    public function _initialize() {
        $where = ['status' => 1, 'name' => $this->getPlugin()->info['name']];
        $vo    = PluginModel::where($where)->cache(60, true)->find();
        if (!$vo) {
            $this->error('评论插件未启用！');
        }

        $adminId = cmf_get_current_admin_id();
        if (!empty($adminId)) {
            $this->assign("admin_id", $adminId);
        } else {
            $this->error('请登录！');
        }
    }

    public function index() {

        $param = $this->request->param();
        $where = [
            'c.delete_time' => 0,
            'c.status'      => ['in', [0, 1]],
        ];

        $startTime = empty($param['start_time']) ? 0 : strtotime($param['start_time']);
        $endTime   = empty($param['end_time']) ? 0 : strtotime($param['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['c.create_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['c.create_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['c.create_time'] = ['<= time', $endTime];
            }
        }

        $keyword = empty($param['keyword']) ? '' : $param['keyword'];
        if (!empty($keyword)) {
            $where['c.content|c.more'] = ['like', "%$keyword%"];
        }

        $status = isset($param['status']) ? $param['status'] : -1;
        if ($status > -1) {
            $where['c.status'] = (int) $status;
        }

        $username = empty($param['username']) ? '' : $param['username'];
        if (!empty($username)) {
            $where['u.user_nickname'] = trim($username);
        }

        $comments = Db::name('comment')->alias('c')
            ->join('__USER__ u', 'c.user_id = u.id', 'left')
            ->join('__USER__ ut', 'c.to_user_id = ut.id', 'left')
            ->field('c.*,u.user_nickname as username,ut.user_nickname as to_username')
            ->where($where)
            ->order('c.create_time DESC')
            ->paginate(10);

        $comments->appends($param);

        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('username', isset($param['username']) ? $param['username'] : '');
        $this->assign('status', isset($param['status']) ? $param['status'] : '');
        $this->assign('list', $comments);
        $this->assign('page', $comments->render());
        return $this->fetch('/admin_index');
    }

    public function del($id = 0, $oid = 0) {
        if (Db::name('comment')->update(['id' => (int) $id, 'delete_time' => time(), 'status' => 2])) {
            PortalPostModel::where('id=' . (int) $oid)->setDec('comment_count');
            $this->success('删除成功');
        }
        $this->error('删除失败');
    }

    public function pass($ids) {
        if (Db::name('comment')->where(['id' => ['in', $ids]])->update(['status' => 1]) !== false) {
            $this->success('审核成功');
        }
        $this->error('审核失败');
    }

    public function delall() {
        $ids = $this->request->param('ids/a');
        if (is_array($ids)) {
            $d = Db::name('comment')->field('id,object_id')->where(['id' => ['in', $ids]])->select()->toArray();
            Db::name('comment')->where(['id' => ['in', array_map('reset', $d)]])->update(['delete_time' => time(), 'status' => 2]);
            $r = array_count_values(array_map('end', $d));
            foreach ($r as $key => $v) {
                PortalPostModel::where('id=' . $key)->setDec('comment_count', $v);
            }
            $this->success('删除成功！');
        }
        $this->success('删除失败！');
    }
}