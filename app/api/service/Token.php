<?php
/**
 * Created by PhpStorm.
 * User: cary
 * Date: 2018/12/19
 * Time: 15:12
 */

namespace app\api\service;

use think\Cache;
use think\Request;

class Token {

    // 生成令牌
    public static function generateToken() {
        $randChar = getRandChar(32);
        $timestamp = time() + 100;
        $tokenSalt = config('api_token_aslt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    public static function needPrimaryScope() {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {

        } else {

        }
    }

    public static function getCurrentTokenVar($key) {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {

        } else {
            if(!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else{
//                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    /**
     * 从缓存中获取当前用户指定身份标识
     * @param array $keys
     * @return array result
     * @throws \app\lib\exception\TokenException
     */
    public static function getCurrentIdentity($keys) {
        $token = Request::instance()->header('token');
        $identities = Cache::get($token);
        //cache 助手函数有bug
        //        $identities = cache($token);
        if (!$identities) {
//            throw new TokenException();
        } else {
            $identities = json_decode($identities, true);
            $result = [];
            foreach ($keys as $key) {
                if (array_key_exists($key, $identities)) {
                    $result[$key] = $identities[$key];
                }
            }
            return $result;
        }
    }

}