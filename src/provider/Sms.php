<?php


namespace thans\user\provider;

use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use thans\layuiAdmin\facade\Json;
use thans\user\facade\Config;
use think\facade\Log;

class Sms
{
    protected $sms;
    protected $config;

    public function __construct()
    {
        $this->config = Config::sms();
        if (! $this->config) {
            throw new SmsException('短信验证码配置错误');
        }
        $this->sms = new EasySms($this->config);
    }

    public function send($mobile, $msg, $config)
    {
        $data = $config['data'];
        foreach ($data as &$val) {
            foreach ($msg as $key => $m) {
                $val = str_replace('$'.$key, $m, $val);
            }
        }
        $content = $config['tmpl'];
        foreach ($msg as $key => $m) {
            $content = str_replace('$'.$key, $m, $content);
        }
        try {
            dump([
                'content'  => $content,
                'template' => function ($gateway) use ($config) {
                    if (isset($config['gateways'][$gateway->getName()]['template'])) {
                        return $config['gateways'][$gateway->getName()]['template'];
                    }
                },
                'data'     => $data,
            ]);

            return $this->sms->send($mobile, [
                'content'  => $content,
                'template' => function ($gateway) use ($config) {
                    if (isset($config['gateways'][$gateway->getName()]['template'])) {
                        return $config['gateways'][$gateway->getName()]['template'];
                    }
                },
                'data'     => $data,
            ]);
        } catch (NoGatewayAvailableException $e) {
            $error = [];
            foreach ($e->getExceptions() as $exception) {
                $error[] = $exception->getMessage();
            }
            Log::error('短信发送失败', $error);
            Json::error('短信发送失败');
        }
    }
}
