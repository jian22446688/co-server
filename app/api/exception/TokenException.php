<?php

namespace app\api\exception;

/**
 * Created by PhpStorm.
 * User: flnet
 * Date: 2018/12/19
 * Time: 10:31
 */

class TokenException extends BaseException {
    public $code = 400;
    public $msg = 'token 验证失败';
    public $errorCode = 42000;
}