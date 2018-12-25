<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace plugins\hz_msg_borad\validate;

use think\Validate;

class PostValidate extends Validate
{
    protected $regex = [
        'mobile'=>'/1[345789]{1}\d{9}$/i',
    ];
    protected $rule = [
        // 用|分开
        'name'       => 'require|chsAlpha',
        'phone'     => 'require|mobile',
        'email' => 'email',
        'msg' => 'require|max:500'
    ];

    protected $message = [
        'name.require'       => "姓名不能为空！",
        'name.chsAlpha'       => "姓名只能是汉字、字母！",
        'phone.require'     => "号码不能为空!",
        'phone.mobile'     => "手机号码格式不正确!",
        'email.email' => '邮箱格式不正确',
        'msg.require' => '留言内容不能为空',
        'msg.max' => '留言长度不能超过500'
    ];


}