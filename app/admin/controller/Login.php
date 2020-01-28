<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

/**
* 登录
*/
class Login extends BaseController
{
    
    public function index() {
        return View::fetch();
    }
}