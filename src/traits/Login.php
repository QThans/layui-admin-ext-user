<?php


namespace thans\user\traits;


use thans\layuiAdmin\facade\Json;
use think\facade\Validate;
use think\Request;

trait Login
{
    //混合登录
    public function login(Request $request)
    {
        $this->validator($request);
        $account = $request->param('account');
        if (Validate::isEmail($account)) {
            $where[] = ['email', '=', $account];
        }
        if (Validate::isMobile($account)) {
            $where[] = ['mobile', '=', $account];
        }
        $login = $this->loginVerify(isset($where) ? $where : ['name', '=', $account], $request->param());

        return $this->loginEnd($request, $login) ?: Json::success('登录成功', $login);
    }

    public function loginEnd(Request $request, $user)
    {
    }
}