<?php

namespace app\common\business;
use app\common\model\mysql\Category as CategoryModel;

class Category {

    public $CategoryObj = null;

    public function __construct() {
        $this->CategoryObj = new CategoryModel();
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

        $res = $this->CategoryObj->getCategoryByName($data['name']);
        if ($res) {
            throw new \think\Exception("分类名已存在");
        }
        try {
            $this->CategoryObj->save($data);
        } catch (\Exception $e) {
            throwE($e, config('status.error'), "服务内部异常");
        }

        return $this->CategoryObj->id;
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
        $categorys = $this->CategoryObj->getNormalCategorys($field);
        if (!$categorys) {
            return [];
        } else {
            return $categorys->toArray();
        }
    }
}
