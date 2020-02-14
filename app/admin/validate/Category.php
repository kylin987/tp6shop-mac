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
        'id'    => 'require|number',
        'listorder' => 'require|integer',
    ];

    protected $message = [
        'pid'  => '父级分类id必须',
        'name'  => '分类名称必须',
        'id'    => 'id异常',
        'listorder.require' => '排序必须填写',
        'listorder.integer' => '排序必须为整数',
    ];

    protected $scene = [
        'add'   => ['pid','name'],
        'changeListOrder'   => ['id','listorder'],
    ];
}