<?php
/**
 * Created by PhpStorm.
 * User: flnet
 * Date: 2018/12/19
 * Time: 13:47
 */

class Cors {
    public function appInit(&$params) {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET');
        if(request()->isOptions()) {
            exit();
        }
    }
}