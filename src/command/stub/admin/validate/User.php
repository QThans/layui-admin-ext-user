<?php


namespace app\admin\validate;


use think\Validate;

class User extends Validate
{
    protected $rule
        = [
            'mobile'   => 'mobile',
            'email'    => 'email',
            'name'     => 'min:5|max:50',
            'nickname' => 'min:5|max:50',
            'password' => 'min:6|max:20',
        ];

    protected $message
        = [
            'mobile'   => '请输入正确的手机号',
            'email'    => '请输入正确的邮箱',
            'password' => '密码长度为6-20个字符',
            'nickname' => '昵称为5-20个字符',
            'name'     => '昵称为5-20个字符',
        ];
}