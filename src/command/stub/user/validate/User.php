<?php


namespace app\user\validate;

use think\Validate;

class User extends Validate
{
    protected $rule
        = [
            'mobile'           => 'require|mobile',
            'mail'             => 'require|email',
            'code'             => 'require|min:4|max:20',
            'password'         => 'require|min:6|max:20',
            'nickname'         => 'require|min:5|max:50',
            'avatar'           => 'max:255',
            'new_password'     => 'require|min:6|max:20',
            'confirm_password' => 'require|confirm:new_password',
        ];

    protected $message
        = [
            'mobile'           => '请输入正确的手机号',
            'code'             => '请输入正确的验证码',
            'password.require' => '请输入密码',
            'mail'             => '请输入正确的邮箱',
            'password'         => '密码长度为4-20个字符',
            'nickname'         => '昵称为4-20个字符',
            'avatar'           => '头像地址长度不能大于255个字符',
            'new_password'     => '密码长度为4-20个字符',
            'confirm_password' => '两次输入密码不一致',
        ];
    protected $scene
        = [
            'mobile_code_password' => ['mobile', 'code', 'password'],
            'mobile_code'          => ['mobile', 'code'],
            'mail_code_password'   => ['mail', 'code', 'password'],
            'mail_code'            => ['mail', 'code'],
            'code'                 => ['code'],
            'nickname_avatar'      => ['nickname', 'avatar'],
        ];

    public function scenePasswordSetting()
    {
        $this->message['password'] = '请输入正确的密码';

        return $this->only(['password', 'new_password', 'confirm_password']);
    }
}
