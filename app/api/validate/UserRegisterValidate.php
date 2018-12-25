<?php
/**
 * Created by PhpStorm.
 * User: flnet
 * Date: 2018/12/21
 * Time: 8:57
 */

namespace app\api\validate;


class UserRegisterValidate extends BaseValidate {
    protected $rule = [
        'name' => 'require|max:16',
        'email' => 'require|email',
        'password' => 'require|min:6|max:18',
    ];

    protected $message = [
        'name.require'      => '用户名不能为空',
        'name.max'          => '用户名最多不能超过 16位',
        'email.require'     => '邮箱必须填写',
        'email'             => '不是正确的邮箱',
        'password.require'  => '密码不能为空',
        'passowrd.min'      => '密码最少6位',
        'passowrd.max'      => '密码最大18位',
    ];

}