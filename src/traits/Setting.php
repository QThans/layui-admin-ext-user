<?php


namespace thans\user\traits;


use thans\layuiAdmin\facade\Json;
use thans\user\facade\Config;
use thans\user\facade\User;
use think\facade\Env;
use think\Request;

trait Setting
{
    public function setting(Request $request)
    {
        $this->validator($request);
        $user = $this->update($request->param());

        return $this->settingEnd($request, $user)
            ?: Json::success('更新成功');
    }

    public function settingEnd(Request $request, $user)
    {
    }

    //头像上传
    public function avatar(Request $request)
    {
        $file = $request->file('image');
        if (! $file) {
            Json::error('请选择图片');
        }
        $config = Config::user();
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate([
            'size' => $config['avatar']['size'],
            'ext'  => $config['avatar']['ext'],
        ])->move(Env::get('root_path').'/public/uploads/avatars');
        if ($info) {
            $url  = '/uploads/avatars/'.$info->getSaveName();
            $user = $this->updateAvatar($info, $url);

            return $this->avatarEnd($info, $user, $url)
                ?: Json::success('上传头像成功', '/uploads/avatars/'.$info->getSaveName());
        } else {
            // 上传失败获取错误信息
            Json::error($file->getError());
        }
    }

    public function avatarEnd($info, $user, $url)
    {
    }

    public function password(Request $request)
    {
        $this->passwordValidator($request);
        $user = $this->updatePassword($request->param());

        return $this->passwordEnd($request, $user)
            ?: Json::success('修改密码成功');
    }

    public function passwordEnd(Request $request, $user)
    {
    }
}