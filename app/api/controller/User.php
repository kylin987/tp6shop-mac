<?php

namespace app\api\controller;


class User extends ApiBase {

    public $middleware = [
        'auth' => ['except' => ['hello']],
    ];

    public function index() {
        echo 1;
        dump($this->userId);
    }

    public function hello() {
        echo 'hello';
        dump($this->username);
    }
}