<?php



namespace app\api\validate;

use think\Request;
use think\Validate;

class BaseValidate extends Validate {

    /**
     * 进行参数效验
     * @return bool
     */
    public function goCheck() {
        // 获取http参数
        //参数校验
        $request = Request::instance();
        $params = $request->param();
        unset($params['version']);
        $params['token'] = $request->header('token');
        if(!$this->check($params)) {
            $errmeg = is_array($this->error) ? implode(';', $this->error) : $this->error;
            err('验证参数错误', $errmeg, API_PARAM_VALIDATE_ERROR);
        }
        return true;
    }

    /**
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws err('参数中包含有非法的参数名user_id或者uid')
     */
    public function getDataByRule($arrays = []) {
        $arr = Request::instance()->param();
        $arrays = $arr;
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            err('参数中包含有非法的参数名user_id或者uid', [], API_PARAM_VALIDATE_ERROR);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    //判断是否是正整数
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '') {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //判断是否为空
    protected function isNotEmpty($value, $rule='', $data='', $field='') {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value) {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}