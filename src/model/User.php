<?php

namespace thans\user\model;

use thans\user\exception\InvalidValueException;
use think\App;
use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;

    protected $autoWriteTimestamp = true;

    //敏感字段 不是自己的数据不返回
    protected $sensitive = ['email', 'mobile'];

    protected $hidden = ['password', 'salt', 'delete_time'];

    //只读字段 不允许被更新
    protected $readonly = ['create_ip', 'create_time'];

    protected $type
        = [
            'last_login_time' => 'timestamp',
        ];

    public static function getUserByName($name)
    {
        return self::whereRaw("name=:name", ['name' => $name])->find();
    }

    /**
     * 根据手机号获取用户
     *
     * @static
     *
     * @param $mobile
     *
     * @return array
     * @throws
     */
    public static function getUserByMobile($mobile)
    {
        return self::whereRaw("mobile=:mobile", ['mobile' => $mobile])->find();
    }

    /**
     * 根据邮箱获取用户
     *
     * @static
     *
     * @param $email
     *
     * @return array
     * @throws
     */
    public static function getUserByEmail($email)
    {
        return self::whereRaw("email=:email", ['email' => $email])->find();
    }

    public static function onBeforeInsert(Model $user)
    {
        if (isset($user->name)) {
            if ($user->name
                && self::getUserByName($user->name)
            ) {
                throw new InvalidValueException('该用户名已被注册');
            }
        } else {
            $user->user_login = '';
        }
        if (isset($user->mobile)) {
            if ($user->mobile && self::getUserByMobile($user->mobile)) {
                throw new InvalidValueException('该手机号已被注册');
            }
        } else {
            $user->mobile = '';
        }
        if (isset($user->email)) {
            if ($user->email && self::getUserByEmail($user->email)) {
                throw new InvalidValueException('该邮箱已被注册');
            }
        } else {
            $user->email = '';
        }
        $user->create_ip   = request()->ip();
        $user->create_time = time();
    }

    public static function onBeforeWrite(Model $user)
    {
        $changed = $user->getChangedData();
        if (isset($changed['password'])) {
            if ($changed['password']) {
                $salt           = random_str(20);
                $user->password = encrypt_password(
                    $changed['password'],
                    $salt
                );
                $user->salt     = $salt;
            }
        }
    }

    public static function init()
    {
        if (strpos(App::VERSION, '6.0.0') === false) {
            self::event('before_insert', function ($user) {
                if (isset($user->name)) {
                    if ($user->name
                        && User::getUserByName($user->name)
                    ) {
                        throw new InvalidValueException('该用户名已被注册');
                    }
                } else {
                    $user->user_login = '';
                }
                if (isset($user->mobile)) {
                    if ($user->mobile && User::getUserByMobile($user->mobile)) {
                        throw new InvalidValueException('该手机号已被注册');
                    }
                } else {
                    $user->mobile = '';
                }
                if (isset($user->email)) {
                    if ($user->email && User::getUserByEmail($user->email)) {
                        throw new InvalidValueException('该邮箱已被注册');
                    }
                } else {
                    $user->email = '';
                }
                $user->create_ip   = request()->ip();
                $user->create_time = time();
            });
            self::event('before_write', function ($user) {
                $changed = $user->getChangedData();
                if (isset($changed['password'])) {
                    if ($changed['password']) {
                        $salt           = random_str(20);
                        $user->password = encrypt_password(
                            $changed['password'],
                            $salt
                        );
                        $user->salt     = $salt;
                    }
                }
            });
        }
    }
}
