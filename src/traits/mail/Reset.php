<?php

namespace thans\user\traits\mail;

use thans\layuiAdmin\facade\Json;
use thans\user\facade\Token;
use thans\user\facade\Auth;
use think\facade\Cache;
use think\Request;

//重置邮箱
trait Reset
{
    use Mail;

    protected $scene = 'reset';
    //是否可以存在邮箱
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
        $mail               = Auth::info('email');
        if (! $mail) {
            Json::error('请先绑定手机号');
        }
        $code = $this->sendCode($request, $mail);

        return $this->sendOldCodeEnd($request, $code)
            ?: Json::success('验证码发送成功');
    }

    public function sendOldCodeEnd($request, $mail)
    {
    }

    //第一步验证旧邮箱
    public function validateOld(Request $request)
    {
        $this->oldValidator($request);
        Token::checkToken(
            'reset_old',
            Auth::info('email'),
            md5($request->param('code'))
        );
        Cache::set(Auth::id().'_reset_mail_validate_old', true, 600);

        return $this->validateOldEnd($request) ?: Json::success('验证成功');
    }

    public function validateOldEnd(Request $request)
    {
    }

    public function reset(Request $request)
    {
        $this->validator($request);
        if (! Cache::get(Auth::id().'_reset_mail_validate_old')) {
            Json::success('请先验证现有邮箱');
        }
        Token::checkToken(
            $this->scene,
            $request->param('mail'),
            md5($request->param('code'))
        );
        Cache::set(Auth::id().'_reset_mail_validate_old', false);
        $user = $this->update($request->param());

        return $this->resetEnd($request, $user) ?: Json::success('更换邮箱成功');
    }

    public function resetEnd(Request $request, $user)
    {
    }
}
