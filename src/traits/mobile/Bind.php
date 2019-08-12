<?php


namespace thans\user\traits\mobile;

use thans\layuiAdmin\facade\Json;
use thans\user\facade\Token;
use thans\user\facade\Auth;
use think\Request;

trait Bind
{
    use Mobile;

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
        if (Auth::info('mobile')) {
            Json::error('您已经绑定过手机号');
        }
    }

    public function bind(Request $request)
    {
        $this->validator($request);

        Token::checkToken(
            $this->scene,
            $request->param('mobile'),
            md5($request->param('code'))
        );
        $user = $this->update($request->param());

        return $this->bindEnd($request, $user) ?: Json::success('绑定手机号成功');
    }

    public function bindEnd(Request $request, $user)
    {
    }
}
