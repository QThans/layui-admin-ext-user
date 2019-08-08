<?php


namespace thans\user\traits\mail;


use thans\layuiAdmin\facade\Json;
use thans\user\facade\Config;
use thans\user\facade\Token;
use thans\user\model\User;
use think\facade\Validate;
use think\Request;
use thans\user\facade\Mail as MailSend;

trait Mail
{
    public function sendCode(Request $request, $mail = '')
    {
        $mail = $mail ? $mail : $request->param('mail');
        $this->validateMail($mail);
        list($token, $code) = Token::createSmsCode(
            $mail,
            $this->scene,
            $this->codeExpiredTime,
            $this->codeLength,
            $this->sendCodeInterval
        );

        $template = Config::user()['send_template'][$this->scene];
        MailSend::send($mail, '', $template['mail_title'], $template['mail_tmpl'], [
            'code' => $code,
        ]);

        //send code
        return $this->sendCodeEnd($request, $code)
            ?: Json::success('验证码发送成功');
    }

    public function sendCodeEnd($request, $code)
    {
    }

    public function validateMail($mail)
    {
        if (! Validate::isEmail($mail)) {
            Json::error('邮箱不正确');
        }
        if ($this->needRegister && ! User::getUserByEmail($mail)) {
            Json::error('邮箱未注册');
        }
        if (! $this->canExist && User::getUserByEmail($mail)) {
            Json::error('邮箱已被注册');
        }
    }
}