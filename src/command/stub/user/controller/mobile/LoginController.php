<?php


namespace app\user\controller\mobile;

use thans\jwt\facade\JWTAuth;
use thans\layuiAdmin\facade\Json;
use thans\user\model\User;
use thans\user\traits\mobile\Login;
use think\Request;

class LoginController
{
    use Login;

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('mobile_code');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    //返回值会被输出，请勿传递敏感值
    public function loginVerify(array $data)
    {
        $user = User::getUserByMobile($data['mobile']);
        if (! $user) {
            Json::error('用户不存在');
        }
        $user->last_login_ip   = \think\facade\Request::ip();
        $user->last_login_time = time();
        $user->save();
        $token = JWTAuth::builder(['user_id' => $user['id']]);

        return $token;
    }
}
