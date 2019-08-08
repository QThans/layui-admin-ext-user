<?php


namespace thans\user\traits\mail;

use thans\layuiAdmin\facade\Json;
use thans\user\facade\Token;
use think\Request;

trait Register
{
    use Mail;

    protected $scene = 'register';

    protected $needRegister = false;

    protected $canExist = false;

    protected $codeExpiredTime = 5;

    protected $codeLength = 4;

    protected $sendCodeInterval = 60;

    public function register(Request $request)
    {
        $this->validator($request);
        Token::checkToken(
            $this->scene,
            $request->param('mail'),
            md5($request->param('code'))
        );

        $user = $this->create($request->param());

        return $this->registerEnd($request, $user) ?: Json::success('注册成功');
    }

    public function registerEnd(Request $request, $user)
    {
    }
}
