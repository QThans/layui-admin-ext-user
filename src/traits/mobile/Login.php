<?php

namespace thans\user\traits\mobile;

use thans\layuiAdmin\facade\Json;
use thans\user\facade\Token;
use think\Request;

trait Login
{
    use Mobile;

    protected $scene = 'login';

    //是否可以存在手机号
    protected $canExist = true;

    protected $needRegister = true;

    protected $token;

    protected $codeExpiredTime = 5;

    protected $codeLength = 4;

    protected $sendCodeInterval = 60;

    public function login(Request $request)
    {
        $this->validator($request);
        Token::checkToken(
            $this->scene,
            $request->param('mobile'),
            md5($request->param('code'))
        );
        $login = $this->loginVerify($request->param());

        return $this->loginEnd($request, $login) ?: Json::success('登录成功', $login);
    }

    public function loginEnd(Request $request, $user)
    {
    }
}
