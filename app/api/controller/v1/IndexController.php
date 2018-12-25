<?php
namespace app\api\controller\v1;

use think\exception\HttpException;
use think\exception\HttpResponseException;

class IndexController {

  public function index() {

      echo 'sss';

      return 'dssss';
  }


  public function test() {
    return json_encode(['a'=> 3, 'b' => 5]);
  }

}