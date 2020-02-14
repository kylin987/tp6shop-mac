<?php

namespace app\common\business;
use app\common\model\mysql\Category as CategoryModel;

class Category {

    public $model = null;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    /**
     * 增加分类
     * @param $data
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add($data) {
        $data['status'] = config('status.mysql.table_normal');

        $res = $this->model->getCategoryByName($data['name']);
        if ($res) {
            throw new \think\Exception("分类名已存在");
        }
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            throwE($e, config('status.error'), "服务内部异常");
        }

        return $this->model->id;
    }

    /**
     * 获取栏目信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategorys() {
        $field = "id, name, pid";
        $categorys = $this->model->getNormalCategorys($field);
        if (!$categorys) {
            return [];
        } else {
            return $categorys->toArray();
        }
    }

    /**
     * 获取栏目数据
     * @param $data
     * @param $num
     * @return array
     */
    public function getLists($data, $num) {
        $list = $this->model->getLists($data, $num);
        if (!$list) {
            return [];
        }

        return $list->toArray();
    }

    /**
     * 更新栏目排序
     * @param $data
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listorder($data) {
        if (empty($data['id'])) {
            throw new \think\Exception("栏目id异常");
        }
        $category = $this->model->find($data['id']);
        if (empty($category)) {
            throw new \think\Exception("不存在该记录");
        }

        $data['update_time'] = time();


        try {
            $result = $category->save($data);
        } catch (\Exception $e) {
            throwE($e, config('status.update_error'), "更新数据失败");
        }
        return $result;

    }
}
