<?php

namespace app\api\controller;

/**
* 用户相关api
*/
class User extends ApiBase
{
    protected $middleware = [
        'auth',
    ];

    public function index(){
        echo request()->username;
    }

    public function hello() {
        echo 'hello';
        echo request()->username;
    }
}