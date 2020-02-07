<?php

declare(strict_types=1);
namespace app\api\controller;

use app\BaseController;

/**
* 用户登录
*/
class Login extends BaseController
{
    
    public function index() :object {
        $phoneNumber = input('param.phone_number', '', 'trim');
        $code = input('param.code', 0, 'intval');
        $type = input('param.type', 0, 'intval');

        $data = [
            'phone_number'  => $phoneNumber,
            'code'          => $code,
            'type'          => $type,
        ];

        $validate = new \app\api\validate\User();
        if (!$validate->scene('login')->check($data)) {
            return show(config('status.error'), $validate->getError());
        }

        $result = (new \app\common\business\User())->login($data);

        return show(config('status.error'),'登录失败');
    }
}