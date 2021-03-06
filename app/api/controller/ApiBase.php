<?php

namespace app\api\controller;

use app\BaseController;

/**
* 该控制器是api所有模块需要继承的控制器
*/
class ApiBase extends BaseController
{
    public $userId = 0;
    public $username = '';
    public $accessToken = '';

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $token = $this->request->header("access-token");
        if (!empty($token)) {
            $userInfo = cache(config('redis.token_pre').$token);
            if ($userInfo && $userInfo['id'] > 0 && $userInfo['username'] !== '') {
                $this->userId = $userInfo['id'];
                $this->username = $userInfo['username'];
                $this->accessToken = $token;
            }
        }

    }
}