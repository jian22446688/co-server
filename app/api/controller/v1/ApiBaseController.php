<?php
/**
 * Created by PhpStorm.
 * api 所有控制前的基类
 * User: flnet
 * Date: 2018/12/19
 * Time: 9:13
 */

namespace app\api\controller\v1;

// 导入定义的异常代码类
require APP_PATH .'api/exception/ExceptionCode.php';

use cmf\controller\RestBaseController;
use think\Controller;
use think\exception\HttpResponseException;
use think\Response;

class ApiBaseController extends Controller {

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed $msg 提示信息
     * @param mixed $data 返回的数据
     * @param array $header 发送的Header信息
     * @return void
     */
    protected function crr( $msg = '', $data = '', $code = 0, array $header = [] ) {
        $result = [ 'code' => $code, 'msg'  => $msg, 'data' => $data];
        $type                                   = $this->getResponseType();
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
    protected function err( $msg = '', $data = '',$code = -1, array $header = [] ) {
        if (is_array($msg)) {
            $code = $msg['code'];
            $msg  = $msg['msg'];
        }
        $result = [ 'code' => $code, 'msg'  => $msg, 'data' => $data ];
        $type                                   = $this->getResponseType();
        $header['Access-Control-Allow-Origin']  = '*';
        $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,XX-Device-Type,XX-Token';
        $header['Access-Control-Allow-Methods'] = 'GET,POST,PATCH,PUT,DELETE,OPTIONS';
        $response                               = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType() {
        return 'json';
    }

}