<?php

namespace app\common\model\mysql;

use think\Model;

/**
 * 
 */
class Category extends Model
{
    //开启自动添加时间戳
    protected $autoWriteTimestamp = true;


    /**
     * 根据分类名称查找分类信息
     * @param $name
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryByName($name) {
        if (empty($name)) {
            return false;
        }

        $where = [
            'name'  => trim($name),
        ];

        return $this->where($where)->find();
    }

    /**
     * 获取栏目信息
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategorys($field = "*") {
        $where = [
            'status'    => config('status.mysql.table_normal'),
        ];

        return $this->where($where)->field($field)->select();
    }
}