<?php

namespace app\common\business;

use app\common\model\mysql\User as UserModel;
use app\common\lib\Str;
use app\common\lib\Time;

/**
* 
*/
class User {
    
    public $UserObj = null;

    public function __construct() {
        $this->UserObj = new UserModel();
    }

    public function login($data) {
        $redisCode = cache(config('redis.code_pre').$data['phone_number']);
        if (empty($redisCode) || $redisCode != $data['code']) {
            throw new \think\Exception("不存在该验证码", config('status.captcha_error'));         
        }

        $user = $this->UserObj->getUserByPhoneNumber($data['phone_number']);

        if (!$user) {
            // 不存在该用户，则插入用户数据
            $username = "yz-".$data['phone_number'];
            $userData = [
                'username'  => $username,
                'phone_number'  => $data['phone_number'],
                'type'          => $data['type'],
                'status'        => config('status.mysql.table_normal'),
                'last_login_time'   => time(),
                'last_login_ip'     => request()->ip(),
            ];
            try {
                $this->UserObj->save($userData);
                $userId = $this->UserObj->id;
                return $userId;
            } catch (\Exception $e) {
                throwE($e,config('status.datebase_error'),"数据库内部异常");                 
            }
            
        } else {
            //存在该用户，则更新用户数据
            $updateData = [
                'type'  => $data['type'],
                'last_login_time'   => time(),
                'last_login_ip'     => request()->ip(),
            ];
            try {
                $this->UserObj->updateById($user->id, $updateData);
            } catch (\Exception $e) {
                throwE($e,config('status.update_error'),"数据库更新异常"); 
            }
            $userId = $user->id;
            $username = $user->username;
        }
        $redisIDToken = cache(config('redis.id_pre').$userId);
        if ($redisIDToken) {
            throw new \think\Exception("您已经登录，无需再次登录");            
        }

        $token = Str::getLoginToken($data['phone_number']);
        $redisData = [
            'id'    => $userId,
            'username'  => $username,
        ];

        $res = cache(config('redis.token_pre').$token, $redisData, Time::userLoginExpiresTime($data['type']));

        if ($res) {
            cache(config('redis.id_pre').$userId, $token, Time::userLoginExpiresTime($data['type']));
        }

        return $res ? ['token' => $token, 'username' => $username] : false;
    }
}