<?php


namespace app\user\controller\mail;

use thans\layuiAdmin\facade\Json;
use thans\user\model\User;
use thans\user\traits\mail\Forget;
use think\Request;

class ForgetController
{
    use Forget;

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('mail_code_password');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function update(array $data)
    {
        $user           = User::getUserByEmail($data['mail']);
        $user->password = $data['password'];
        $user->save();

        return $user;
    }
}
