<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use app\common\business\Category as CategoryBis;

class Category extends BaseController
{
    /**
     * 栏目列表
     * @return string
     * @throws \Exception
     */
    public function index() {
        $pid = input("param.pid", 0, "intval");
        $data = [
            'pid'   => $pid,
        ];

        try {
            $categorys = (new CategoryBis())->getLists($data, 5);
        } catch (\Exception $e) {
            $categorys = [];
        }

        View::assign('categorys',$categorys);
        View::assign('pid', $pid);

        return View::fetch();
    }

    /**
     * 新增栏目页面
     * @return string
     * @throws \Exception
     */
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

    /**
     * 新增栏目保存
     * @return \think\response\Json
     */
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

    /**
     * 更新栏目排序
     * @return \think\response\Json
     */
    public function listorder() {
        $id = input("param.id", 0, "intval");
        $listorder = input("param.listorder", 0, "intval");

        $data = [
            'id'    => $id,
            'listorder' => $listorder,
        ];

        $validate = (new \app\admin\validate\Category())->scene('changeListOrder');
        if (!$validate->check($data)) {
            return show(config('status.error'), $validate->getError());
        }
        try {
            $resule = (new CategoryBis())->updateCategory($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }

        if ($resule) {
            return show(config('status.success'), "排序成功", $resule);
        }
        return show(config('status.error'), "排序失败");

    }

    public function changeStatus(){
        $id = input("param.id", 0, "intval");
        $status = input("param.status", 0, "intval");

        $data = [
            'id'    => $id,
            'status' => $status,
        ];

        $validate = (new \app\admin\validate\Category())->scene('changeStatus');
        if (!$validate->check($data)) {
            return show(config('status.error'), $validate->getError());
        }

        if (!in_array($status, \app\common\lib\Status::getTableStatus())) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $resule = (new CategoryBis())->updateCategory($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }

        if ($resule) {
            return show(config('status.success'), "更新成功", $resule);
        }
        return show(config('status.error'), "更新失败");
    }
}