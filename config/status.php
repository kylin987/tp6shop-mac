<?php
// +----------------------------------------------------------------------
// | 业务代码设置
// +----------------------------------------------------------------------


return [
    // 成功
    'success'   => 1,
    // 错误
    'error'     => 0,

    'captcha_error' => -1001,

    'mysql' => [
        'table_normal'  => 1,   //正常
        'table_pedding' => 0,   //待审核
        'table_delete'  => 99,  //删除
    ],
];
