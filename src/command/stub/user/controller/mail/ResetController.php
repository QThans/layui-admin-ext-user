<?php


namespace app\user\controller\mail;

use thans\layuiAdmin\facade\Json;
use thans\user\facade\User;
use thans\user\traits\mail\Reset;
use think\Request;

class ResetController
{
    use Reset;

    public function oldValidator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('code');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function validator(Request $request)
    {
        $validate = (new \app\user\validate\User())->scene('mail_code');
        if (! $validate->check($request->param())) {
            Json::error($validate->getError());
        }
    }

    public function update(array $data)
    {
        $user        = User::info();
        $user->email = $data['mail'];
        $user->save();

        return $user;
    }
}
