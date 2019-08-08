<?php


namespace app\user\controller\mail;


use thans\layuiAdmin\facade\Json;
use thans\user\facade\User;
use thans\user\traits\mail\Bind;
use think\Request;

class BindController
{
    use Bind;

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