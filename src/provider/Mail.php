<?php


namespace thans\user\provider;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use thans\layuiAdmin\facade\Json;
use thans\user\facade\Config;

class Mail
{
    protected $config;

    protected $mail;

    public function __construct()
    {
        $this->config = Config::mail();
        $this->mail   = new PHPMailer(true);
    }

    public function send($address, $name, $title, $tmpl, $data = [])
    {
        try {
            //Server settings
            //            $this->mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $this->mail->isSMTP();                                            // Set mailer to use SMTP
            $this->mail->Host     = $this->config['mail_host'];  // Specify main and backup SMTP servers
            $this->mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $this->mail->Username = $this->config['mail_username'];                     // SMTP username
            $this->mail->Password = $this->config['mail_password'];                               // SMTP password
            $this->mail->SMTPSecure
                                  = $this->config['mail_encryption'];                                  // Enable TLS encryption, `ssl` also accepted
            $this->mail->Port
                                  = $this->config['mail_port'];                                    // TCP port to connect to
            //Recipients
            $this->mail->setFrom($this->config['mail_username'], env('app_name'));
            $this->mail->addAddress($address, $name);     // Add a recipient

            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $title;
            $content             = file_get_contents($tmpl);
            foreach ($data as $key => $val) {
                $content = str_replace('{$'.$key.'}', $val, $content);
            }
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Body    = $content;
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            Json::error("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
        }
    }
}
