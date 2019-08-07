<?php

namespace thans\user\provider;

use thans\jwt\facade\JWTAuth;
use thans\user\model\User as UserModel;

class User
{
    protected $auth;

    public function __construct()
    {
        $this->auth = JWTAuth::auth();
    }

    public function id()
    {
        return (String)$this->auth['user_id'];
    }

    public function info($key = '')
    {
        $user = UserModel::get($this->id());
        if ($key) {
            return $user[$key];
        }

        return $user;
    }
}