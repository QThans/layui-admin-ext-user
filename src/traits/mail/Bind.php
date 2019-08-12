<?php


namespace thans\user\traits\mail;

use thans\layuiAdmin\facade\Json;
use thans\user\facade\Token;
use thans\user\facade\Auth;
use think\Request;

trait Bind
{
    use Mail;
    protected $scene = 'bind';

    //是否可以存在手机号
    protected $canExist = false;

    protected $needRegister = false;

    protected $token;

    protected $codeExpiredTime = 5;

    protected $codeLength = 4;

    protected $sendCodeInterval = 60;

    public function __construct()
    {
        if (Auth::info('email')) {
            Json::error('您已经绑定过邮箱');
        }
    }

    public function bind(Request $request)
    {
        $this->validator($request);

        Token::checkToken(
            $this->scene,
            $request->param('mail'),
            md5($request->param('code'))
        );
        $user = $this->update($request->param());

        return $this->bindEnd($request, $user) ?: Json::success('绑定邮箱成功');
    }

    public function bindEnd(Request $request, $user)
    {
    }
}
