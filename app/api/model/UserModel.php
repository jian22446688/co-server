<?php
/**
 * Created by PhpStorm.
 * User: flnet
 * Date: 2018/12/20
 * Time: 14:28
 */

namespace app\api\model;


use think\Model;

class UserModel extends Model {

    // 使用user_type 字段标注用户属于哪里注册来的用户 通过 api 标注为 3

    public function registered($user, $type) {
        switch ($type) {
            case 1:
                $result = Db::name("user")->where('user_login', $user['user_login'])->find();
                break;
            case 2:
                $result = Db::name("user")->where('mobile', $user['mobile'])->find();
                break;
            case 3:
                $result = Db::name("user")->where('user_email', $user['user_email'])->find();
                break;
            default:
                $result = 0;
        }

        $userStatus = 1;

        if (cmf_is_open_registration()) {
            $userStatus = 2;
        }

        if (empty($result)) {
            $data   = [
                'user_login'      => empty($user['user_login']) ? '' : $user['user_login'],
                'user_email'      => empty($user['user_email']) ? '' : $user['user_email'],
                'mobile'          => empty($user['mobile']) ? '' : $user['mobile'],
                'user_nickname'   => '',
                'user_pass'       => cmf_password($user['user_pass']),
                'last_login_ip'   => get_client_ip(0, true),
                'create_time'     => time(),
                'last_login_time' => time(),
                'user_status'     => $userStatus,
                "user_type"       => 2,//会员
            ];
            $userId = Db::name("user")->insertGetId($data);
            $data   = Db::name("user")->where('id', $userId)->find();
            cmf_update_current_user($data);
            $token = cmf_generate_user_token($userId, 'web');
            if (!empty($token)) {
                session('token', $token);
            }
            return 0;
        }
        return 1;
    }

    public function register($user) {
        $result = self::where('user_email', $user['email'])->find();
        $resultname = self::where('user_login', $user['name'])->find();
        if(!empty($result)) return 1;
        if(!empty($resultname)) return 2;
        $data = [
            'user_type'         => 3,                                   // api 注册的用户统一使用 3
            'user_login'        => $user['name'],                       // 登录用户名
            'user_email'        => $user['email'],                      // 用户邮箱地址
            'user_pass'         => cmf_password($user['password']),     // 用户密码 加密
            'last_login_ip'     => get_client_ip(),                     // 用户注册的pi地址
            'create_time'       => time(),                              // 用户注册的时间
            'last_login_time'   => time(),                              // 用户注册的时间 as 字段的作用就是用户的做后登录的时间
            'user_status'       => 1,                                   // 用户注册的时候状态 0 禁用, 1 正常, 2 禁用
        ];
        $_userid = self::create($data);
        $token = cmf_generate_user_token($_userid['id'], 'api');
        if(!empty($token)) {
            cache($token, $_userid);
        }
        return 0;
    }


}