<?php


namespace app\user\controller\mobile;


use thans\layuiAdmin\facade\Json;
use thans\user\model\User;
use thans\user\traits\mobile\Forget;
use think\Request;

class ForgetController
{
    use Forget;

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('mobile_code_password');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function update(array $data)
    {
        $user           = User::getUserByMobile($data['mobile']);
        $user->password = $data['password'];
        $user->save();

        return $user;
    }
}