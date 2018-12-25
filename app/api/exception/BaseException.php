<?php

namespace app\api\exception;

use think\Exception;

class BaseException extends Exception
{
    // HTTP 状态码 400,200
    public $code = 400;
    // 错误信息
    public $msg = '参数错误';
    //自定义错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        if (!is_array($params))
        {
            return;
        }

        if (array_key_exists('code', $params))
        {
            $this->code = $params['code'];
        }

        if (array_key_exists('msg', $params))
        {
            $this->msg = $params['msg'];
        }

        if (array_key_exists('errorCode', $params))
        {
            $this->errorCode = $params['errorCode'];
        }
    }
}