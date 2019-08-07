<?php

namespace thans\user\traits\mobile;

use thans\jwt\facade\JWTAuth;
use thans\layuiAdmin\facade\Json;
use thans\user\facade\Sms;
use thans\user\facade\Token;
use thans\user\facade\User;
use think\facade\Cache;
use think\Request;

//重置手机号
trait Reset
{
    use Mobile;

    protected $scene = 'reset';
    //是否可以存在手机号
    protected $canExist = true;

    protected $needRegister = true;

    protected $token;

    protected $codeExpiredTime = 5;

    protected $codeLength = 4;

    protected $sendCodeInterval = 60;

    public function sendNewCode(Request $request)
    {
        $this->canExist     = false;
        $this->scene        = 'reset';
        $this->needRegister = false;
        $code               = $this->sendCode($request);

        return $this->sendNewCodeEnd($request, $code)
            ?: Json::success('验证码发送成功');
    }

    public function sendCodeEnd(Request $request, $code = '')
    {
        return $code;
    }

    public function sendNewCodeEnd(Request $request, $code)
    {
    }

    public function sendOldCode(Request $request)
    {
        $this->canExist     = true;
        $this->scene        = 'reset_old';
        $this->needRegister = false;
        $code               = $this->sendCode($request, User::info('mobile'));

        return $this->sendOldCodeEnd($request, $code)
            ?: Json::success('验证码发送成功');
    }

    public function sendOldCodeEnd($request, $mobile)
    {
    }

    //第一步验证旧手机号
    public function validateOld(Request $request)
    {
        $this->oldValidator($request);
        Token::checkToken(
            'reset_old',
            $request->param('mobile'),
            md5($request->param('code'))
        );
        Cache::set(User::id().'_reset_validate_old', true, 600);

        return $this->validateOldEnd($request) ?: Json::success('验证成功');
    }

    public function validateOldEnd(Request $request)
    {
    }

    public function reset(Request $request)
    {
        $this->validator($request);
        if (! Cache::get(User::id().'_reset_validate_old')) {
            Json::success('请先验证现有手机号');
        }
        Token::checkToken(
            $this->scene,
            $request->param('mobile'),
            md5($request->param('code'))
        );
        Cache::set(User::id().'_reset_validate_old', false);
        $user = $this->update($request->param());

        return $this->resetEnd($request, $user) ?: Json::success('更换手机号成功');
    }

    public function resetEnd(Request $request, $user)
    {
    }

}
