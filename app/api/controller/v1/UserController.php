<?php
/**
 * Created by PhpStorm.
 * User: cary
 * Date: 2018/12/19
 * Time: 8:14
 */

namespace app\api\controller\v1;


use app\api\service\Token;
use app\lib\JWT;
use think\Cache;

class UserController extends BaseTokenController {

    public function login() {

        crr('获取成功', ['s' =>Token::generateToken()]);
    }

    /**
     * 获取用户信息
     * 不需要传入任何参数
     * 会根据 header 里面的 token 来获取
     */
    public function getUserInfo() {

        $this->crr('用户信息获取成功');
    }

    /**
     *
     */
    public function getToken() {
        $tokenstr = config('api_token_expiration');
        $cath = cache('ccc', 'aaa');
        return json_encode($cath);
    }

    public function checkToken() {
        $obj = $this->request->header('token');
        $ch = Cache::get('ccc');
        dump($ch);
        return 'd';
    }


}