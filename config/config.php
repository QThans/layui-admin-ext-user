<?php

$mailDefaultTmpl  = env('app_path').'user'.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.'mail'.DIRECTORY_SEPARATOR
    .'code.html';
$mailDefaultTitle = '【'.config('app.app_name').'】您本次的验证码是';

return [
    'avatar'        => [
        'size' => 1024000, //bytes
        'ext'  => 'jpg,png,jpeg',
    ],
    'send_template' => [
        'register'        => [
            'mail_title' => $mailDefaultTitle,
            'mail_tmpl'  => $mailDefaultTmpl,
            'tmpl'       => "您的验证码是：\$code，请妥善保管。",
            'gateways'   => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'       => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'forget_password' => [
            'mail_title' => $mailDefaultTitle,
            'mail_tmpl'  => $mailDefaultTmpl,
            'tmpl'       => "您的验证码是：\$code，请妥善保管。",
            'gateways'   => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'       => [
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
            'mail_title' => $mailDefaultTitle,
            'mail_tmpl'  => $mailDefaultTmpl,
            'tmpl'       => "您的验证码是：\$code，请妥善保管。",
            'gateways'   => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'       => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'reset_old'       => [
            'mail_title' => $mailDefaultTitle,
            'mail_tmpl'  => $mailDefaultTmpl,
            'tmpl'       => "您的验证码是：\$code，请妥善保管。",
            'gateways'   => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'       => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
        'bind'            => [
            'mail_title' => $mailDefaultTitle,
            'mail_tmpl'  => $mailDefaultTmpl,
            'tmpl'       => "您的验证码是：\$code，请妥善保管。",
            'gateways'   => [
                "submail" => [
                    "template" => "QgkCv",
                ],
            ],
            'data'       => [
                'code'    => '$code',
                'project' => 'QgkCv',
            ],//可扩展字段
        ],
    ],

];