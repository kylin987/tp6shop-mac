<?php

namespace app\api\controller;


class Logout extends ApiBase
{
    public $middleware = ['auth'];

    /**
     * 退出登录
     * @return \think\response\Json
     */
    public function index() {
        //删除redis token的缓存
        dump($this->accessToken);
        if ($this->accessToken) {
            $res = cache(config('redis.token_pre').$this->accessToken, null);
        }
        if ($res) {
            if ($this->userId) {
                $result = cache(config('redis.id_pre').$this->userId, null);
            }
        }

        if ($result) {
            return show(config('status.success'), "退出登录成功");
        }

        return show(config('status.error'), "退出登录失败");

    }
}