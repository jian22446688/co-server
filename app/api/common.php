<?php

use think\Response;
use think\exception\HttpResponseException;
/**
 * Created by PhpStorm.
 * User: cary
 * Date: 2018/12/19
 * Time: 13:57
 * @throws HttpResponseException
 */

/**
 * 操作成功跳转的快捷方法
 * @access protected
 * @param mixed $msg 提示信息
 * @param mixed $data 返回的数据
 * @param array $header 发送的Header信息
 * @return void
 */
function crr( $msg = '', $data = '', $code = 0, array $header = [] ) {
    $result = [ 'code' => $code, 'msg'  => $msg, 'data' => $data];
    $type                                   = 'json';
    $header['Access-Control-Allow-Origin']  = '*';
    $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,XX-Device-Type,XX-Token,XX-Api-Version,XX-Wxapp-AppId';
    $header['Access-Control-Allow-Methods'] = 'GET,POST,PATCH,PUT,DELETE,OPTIONS';
    $response                               = Response::create($result, $type)->header($header);
    throw new HttpResponseException($response);
}

/**
 * 操作错误跳转的快捷方法
 * @access protected
 * @param mixed $msg 提示信息,若要指定错误码,可以传数组,格式为['code'=>您的错误码,'msg'=>'您的错误消息']
 * @param mixed $data 返回的数据
 * @param array $header 发送的Header信息
 * @return void
 */
function err( $msg = '', $data = '',  $code = -1, array $header = [] ) {
    if (is_array($msg)) {
        $code = $msg['code'];
        $msg  = $msg['msg'];
    }
    $result = [ 'code' => $code, 'msg'  => $msg, 'data' => $data ];
    $type                                   = 'json';
    $header['Access-Control-Allow-Origin']  = '*';
    $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,XX-Device-Type,XX-Token';
    $header['Access-Control-Allow-Methods'] = 'GET,POST,PATCH,PUT,DELETE,OPTIONS';
    $response                               = Response::create($result, $type)->header($header);
    throw new HttpResponseException($response);
}


/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array()) {
    $data_string = json_encode($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

function curl_post_raw($url, $rawData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text')
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curl_get($url, &$httpCode = 0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}

/**
 * 获取自定义长度
 * @param $length
 * @return null|string
 */
function getRandChar($length) {
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}



function fromArrayToModel($m , $array) {
    foreach ($array as $key => $value) {
        $m[$key] = $value;
    }
    return $m;
}
