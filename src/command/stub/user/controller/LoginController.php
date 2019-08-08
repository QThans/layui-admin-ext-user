<?php


namespace app\user\controller;

use thans\jwt\facade\JWTAuth;
use thans\layuiAdmin\facade\Json;
use thans\user\model\User;
use thans\user\traits\Login;
use think\Request;

class LoginController
{
    use Login;

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\Login())->scene('account_password');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    //返回值会被输出，请勿传递敏感值
    public function loginVerify($where, array $data)
    {
        $user = User::where($where)->find();
        if (! $user) {
            Json::error('用户不存在');
        }
        if ($user['password'] == encrypt_password($data['password'], $user['salt'])) {
            $token = JWTAuth::builder(['user_id' => $user['id']]);

            return $token;
        }
        Json::error('密码错误');
    }
}
