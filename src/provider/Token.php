<?php

namespace thans\user\provider;

use thans\layuiAdmin\facade\Json;
use thans\user\model\Token as TokenModel;

class Token
{
    public function createToken($scene, $object, $token, $expiredTime)
    {
        return TokenModel::create([
            'scene'        => $scene,
            'object'       => $object,
            'token'        => $token,
            'expired_time' => $expiredTime * 60 + time(),
        ]);
    }

    public function createSmsCode($mobile, $scene, $expiredTime, $length = 4, $sendCodeInterval = 60)
    {
        $code = random_str($length, true);
        $last = $this->getToken($scene, $mobile);
        if ($last && (time() - $last->getData('create_time')) <= $sendCodeInterval) {
            Json::error('验证码发送时间间隔太短');
        }
        $token = $this->createToken($scene, $mobile, $code, $expiredTime);

        return [$token, $code];
    }

    public function checkToken($scene, $object, $token, $verified = true)
    {
        $token = $this->getToken($scene, $object, $token);
        if (! $token || $token['verified_time']) {
            Json::error('请输入正确的验证码');
        }
        if ($token['expired_time'] < time()) {
            Json::error('验证码已过期');
        }
        //verified
        if (! $verified) {
            return true;
        }
        $token->verified_time = time();

        return $token->save();
    }

    public function getToken($scene, $object, $token = '')
    {
        $map   = [];
        $map[] = ['scene', '=', $scene];
        $map[] = ['object', '=', $object];
        if ($token) {
            $map[] = ['token', '=', $token];
        }

        return TokenModel::where($map)->order('create_time desc')->find();
    }
}
