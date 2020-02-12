<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 管理员登录验证器
 */
class Category extends Validate
{
    
    protected $rule = [
        'pid'  => 'require',
        'name'  => 'require',
    ];

    protected $message = [
        'pid'  => '父级分类id必须',
        'name'  => '分类名称必须',
    ];

    protected $scene = [
        'add'   => ['pid','name'],
    ];
}