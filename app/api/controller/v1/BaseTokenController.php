<?php
/**
 * Created by PhpStorm.
 * 需要用户验证集成此方法
 * User: flnet
 * Date: 2018/12/19
 * Time: 9:11
 */

namespace app\api\controller\v1;

use app\api\exception\TokenException;
use think\App;use think\Controller;

class BaseTokenController extends ApiBaseController {

    public function _initialize() {
        // todo 用于用户验证
        $token = $this->request->header('token');
        if(!$token) {
            $this->err('token 无效', '', API_TOKEN_NO);
        } else {
            $ceah = cache($token);
            if(!$ceah) {
                $this->err('token 验证失败', '', API_TOKEN_FAILE);
            }
        }
    }

}