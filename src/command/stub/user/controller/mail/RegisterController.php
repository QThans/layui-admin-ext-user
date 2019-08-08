<?php


namespace app\user\controller\mail;


use thans\layuiAdmin\facade\Json;
use thans\user\model\User;
use thans\user\traits\mail\Register;
use think\Request;

class RegisterController
{
    use Register;

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('mail_code_password');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function create(array $data)
    {
        $data['salt'] = random_str(20);

        return User::create([
            'email'    => $data['mail'],
            'salt'     => $data['salt'],
            'password' => encrypt_password($data['password'], $data['salt']),
        ]);
    }
}