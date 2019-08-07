<?php


namespace thans\user\traits\mobile;


use thans\layuiAdmin\facade\Json;
use thans\user\facade\Sms;
use thans\user\facade\Token;
use thans\user\model\User;
use think\facade\Validate;
use think\Request;

trait Mobile
{
    public function sendCode(Request $request, $mobile = '')
    {
        $mobile = $mobile ? $mobile : $request->param('mobile');
        $this->validateMobile($mobile);
        list($token, $code) = Token::createSmsCode(
            $mobile,
            $this->scene,
            $this->codeExpiredTime,
            $this->codeLength,
            $this->sendCodeInterval
        );

        Sms::sendMobileCode($mobile, [
            'code' => $code,
        ], $this->scene);

        //send code
        return $this->sendCodeEnd($request, $code)
            ?: Json::success('验证码发送成功');
    }

    protected function validateMobile($mobile)
    {
        if (! Validate::isMobile($mobile)) {
            Json::error('手机号不正确');
        }
        if ($this->needRegister && ! User::getUserByMobile($mobile)) {
            Json::error('手机号未注册');
        }
        if (! $this->canExist && User::getUserByMobile($mobile)) {
            Json::error('手机号已被注册');
        }
    }

    public function sendCodeEnd(Request $request, $code)
    {
    }
}