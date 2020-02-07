<?php

namespace app\api\validate;

use think\Validate;

/**
 * 数据校验
 */
class User extends Validate
{
    
    protected $rule = [
        'username'  => 'require',
        'phone_number'  => 'require|mobile',
        'code'  => 'require|number|min:4',
        'type'  => 'require|in:1,2',
        //'type'  => ['require', 'in'=> '1,2'], //和上面一样
    ];

    protected $message = [
        'username'  => '用户名必须',
        'phone_number.require'  => '手机号必须',
        'phone_number.mobile'   => '请填写正确的手机号',
        'code.require'  => '请填写收到的验证码',
        'code.number'   => '验证码必须为数字',
        'code.min'      => '验证码至少4位',
        'type.require'  => '类型必须',
        'type.in'       => '类型数值异常',
    ];

    protected $scene = [
        'send_code' => ['phone_number'],
        'login'     => ['phone_number','code','type'],
    ];
}