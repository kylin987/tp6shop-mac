<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use app\common\business\Category as CategoryBis;

class Category extends BaseController
{
    public function index() {
        return View::fetch();
    }

    public function add() {
        try {
            $categorys = (new CategoryBis())->getNormalCategorys();
        } catch (\Exception $e) {
            $categorys = [];
        }

        return View::fetch("", [
            'categorys' => json_encode($categorys),
        ]);
    }

    public function save() {
        $pid = input("param.pid", 0, "intval");
        $name = input("param.name", "", "trim");

        $data = [
            'pid'   => $pid,
            'name'  => $name,
        ];

        $validate = (new \app\admin\validate\Category())->scene('add');
        if (!$validate->check($data)) {
            return show(config('status.error'), $validate->getError());
        }

        try {
            $result = (new CategoryBis())->add($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }

        return show(config('status.success'), "ok", $result);
    }
}