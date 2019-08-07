<?php
return [
    'mail_host'       => env('MAIL_HOST'),
    'mail_port'       => env('MAIL_PORT'),
    'mail_username'   => env('MAIL_USERNAME'),
    'mail_password'   => env('MAIL_PASSWORD'),
    'mail_encryption' => env('MAIL_ENCRYPTION'),
    'sms_template'    => [
        'register'        => [
            'tmpl'     => "您的验证码是：\$code，请妥善保管。",
            'gateways' => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'     => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'forget_password' => [
            'tmpl'     => "您的验证码是：\$code，请妥善保管。",
            'gateways' => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'     => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'login'           => [
            'tmpl'     => "您的验证码是：\$code，请妥善保管。",
            'gateways' => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'     => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'reset'           => [
            'tmpl'     => "您的验证码是：\$code，请妥善保管。",
            'gateways' => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'     => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'reset_old'       => [
            'tmpl'     => "您的验证码是：\$code，请妥善保管。",
            'gateways' => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'     => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
    ],

];