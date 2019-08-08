<?php


namespace app\user\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule
        = [
            'account'  => 'require|min:4|max:100',
            'password' => 'require|min:6|max:20',
        ];

    protected $message
        = [
            'password' => '密码错误',
            'account'  => '用户名错误',
        ];
    protected $scene
        = [
            'account_password' => ['account', 'password'],
        ];
}
