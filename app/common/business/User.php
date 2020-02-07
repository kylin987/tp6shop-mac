<?php

namespace app\common\business;

use app\common\model\mysql\User as UserModel;

/**
* 
*/
class User {
    
    public $UserObj = null;

    public function __construct() {
        $this->UserObj = new UserModel();
    }

    public function login($data) {
        $redisCode = cache(config('redis.code_pre').$data['phone_number']);
        if (empty($redisCode) || $redisCode != $data['code']) {
            throw new \think\Exception("不存在该验证码", config('status.captcha_error'));
            
        }
    }
}