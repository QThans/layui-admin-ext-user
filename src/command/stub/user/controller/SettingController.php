<?php


namespace app\user\controller;


use thans\layuiAdmin\facade\Json;
use thans\user\facade\User;
use thans\user\traits\Setting;
use think\Request;

class SettingController
{
    use Setting;

    protected $field = ['avatar', 'nickname'];

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('nickname_avatar');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function passwordValidator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('passwordSetting');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function updatePassword(array $data)
    {
        $user = User::info();
        if ($user['password'] != encrypt_password($data['password'], $user['salt'])) {
            Json::error('请输入正确的密码');
        }
        $user->password = $data['new_password'];
        $user->save();

        return $user;
    }

    public function update(array $data)
    {
        $user = User::info();
        $user = $user->allowField($this->field)->save($data);

        return $user;
    }

    public function updateAvatar($info, $url)
    {
        $user         = User::info();
        $user->avatar = $url;
        $user->save();

        return $user;
    }
}