<?php
/**
 * Created by PhpStorm.
 * User: flnet
 * Date: 2018/12/19
 * Time: 16:41
 */

namespace app\api\controller\v1;


use app\api\model\UserModel;
use app\api\service\Token;
use app\api\validate\UserRegisterValidate;

class LoginController extends ApiBaseController {

    protected $beforeActionList = [ 'check_token' ];

    protected function check_token () {

//        $this->err('验证错误,');
    }

    /**
     * 用户登录
     * @method post
     * @param name
     * @param password
     */
    public function login() {
        $uname = 'cary';
        $upaw = '123456';
        $resu = $this->request->param();
        if($uname != $resu['name'] || $upaw != $resu['password']) {
            $this->err('账号密码错误', [], API_USER_LOGIN);
        }
        $token = Token::generateToken();
        cache($token, 'cary');
        $this->crr('成功', $token);
    }

    /**
     * api 用户注册
     * @method post
     * @param name
     * @param passwrod
     * @param email
     */
    public function register() {
        $validate = new UserRegisterValidate();
        $validate->goCheck();
        $_userModel = new UserModel();
        $_u = $_userModel->register($validate->getDataByRule());
        if($_u == 0) {
            $this->crr('用户注册成功');
        }else if($_u == 1) {
            $this->err('用户注册失败, 邮箱被占用', API_USER_REGISTER_EMAIL);
        } else if($_u == 2) {
            $this->err('用户注册失败, 用户名被占用', API_USER_REGISTER_NAME);
        }else {
            $this->err('用户注册失败, 未知错误', API_UNKONWN_ERROR);
        }
    }

    /**
     * 用户使用手机登录
     */
    public function phoneLogin() {

    }


}