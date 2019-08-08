<?php
//配置文档请看：https://github.com/overtrue/easy-sms
return [
    // HTTP 请求的超时时间（秒）
    'timeout'  => 5.0,

    // 默认发送配置
    'default'  => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun'   => [
            'access_key_id'     => env('aliyun.access_key_id'),
            //配置模式以gateways为父级 阿里云则：env('aliyun.access_key_id') submail则env('submail.access_key_id')
            'access_key_secret' => env('aliyun.access_key_secret'),
            'sign_name'         => env('aliyun.sign_name'),
        ],
        //...
    ],
];
