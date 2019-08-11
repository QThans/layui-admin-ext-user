<?php


namespace app\user\controller\mobile;

use thans\layuiAdmin\facade\Json;
use thans\user\model\User;
use thans\user\traits\mobile\Register;
use think\Request;

class RegisterController
{
    use Register;

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('mobile_code_password');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function create(array $data)
    {
        $data['salt'] = random_str(20);

        return User::create([
            'mobile'      => $data['mobile'],
            'register_ip' => \think\facade\Request::ip(),
            'password'    => $data['password'],
        ]);
    }
}
