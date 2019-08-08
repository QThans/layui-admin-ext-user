<?php


namespace thans\user\traits\mail;


use thans\layuiAdmin\facade\Json;
use thans\user\facade\Token;
use think\Request;

trait Forget
{
    use Mail;
    protected $scene = 'forget_password';

    //是否可以存在手机号
    protected $canExist = true;

    protected $needRegister = true;

    protected $token;

    protected $codeExpiredTime = 5;

    protected $codeLength = 4;

    protected $sendCodeInterval = 60;

    public function forget(Request $request)
    {
        $this->validator($request);

        Token::checkToken(
            $this->scene,
            $request->param('mail'),
            md5($request->param('code'))
        );
        $user = $this->update($request->param());

        return $this->forgetEnd($request, $user) ?: Json::success('密码修改成功');
    }

    public function forgetEnd(Request $request, $user)
    {
    }
}