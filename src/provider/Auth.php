<?php

namespace thans\user\provider;

use thans\jwt\exception\JWTException;
use thans\jwt\facade\JWTAuth;
use thans\user\model\User as UserModel;

class Auth
{
    protected $payload;

    public function auth()
    {
        try {
            $this->payload = JWTAuth::getPayload();
        } catch (JWTException $e) {
            return false;
        }

        return $this;
    }

    public function id()
    {
        return $this->auth() ? $this->payload['user_id'] : null;
    }

    public function check()
    {
        return $this->auth() ? true : false;
    }

    public function info($key = '')
    {
        if (! $this->auth()) {
            return null;
        }
        $user = UserModel::get($this->id());
        if ($key) {
            return $user[$key];
        }

        return $user;
    }
}
