<?php


namespace thans\user\model;

use think\Model;

class Token extends Model
{
    protected $autoWriteTimestamp = true;

    public function setTokenAttr($value)
    {
        return md5($value);
    }
}
