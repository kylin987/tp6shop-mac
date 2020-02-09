<?php

namespace app\common\model\mysql;

use think\Model;

/**
 * 
 */
class User extends Model
{
    //开启自动添加时间戳
    protected $autoWriteTimestamp = true;
    //根据手机号获取用户表的数据
    public function getUserByPhoneNumber($phone_number)
    {
        if (empty($phone_number)) {
            return false;
        }

        $where = [
            'phone_number'  => $phone_number,
        ];

        $result = $this->where($where)->find();
        return $result;
    }

    //根据主键id更新数据表中的数据
    public function updateById($id, $data) {
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }

        $where = [
            'id'    => $id,
        ];

        return $this->where($where)->save($data);
    }
}