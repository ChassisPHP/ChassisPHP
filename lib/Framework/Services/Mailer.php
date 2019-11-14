<?php

namespace Lib\Framework\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail;
    private $body;
    private $view;
    private $config;

    public function __construct($view, $mailConfig)
    {
        $this->view = $view;
        $this->config = $mailConfig;
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host = $this->config['host'];
        $this->mail->SMTPAuth = true;

        // debug/testing
        //$this->mail->SMTPDebug = 4;

        /* Set the encryption system, if needed. */
        if ($this->config['tls'] == 'tls') {
            $this->mail->SMTPSecure = 'tls';
        }

        /* SMTP authentication username. */
        $this->mail->Username = $this->config['username'];

        /* SMTP authentication password. */
        $this->mail->Password = $this->config['password'];

        /* Set the SMTP port. */
        $this->mail->Port = (int) $this->config['port'];
        if ($this->config['cc']!= '') {
            $this->mail->addCC($this->config['cc']);
        }
    }

    // @return true on success
    public function send(
        $recipients,
        $subject,
        $bodyData,
        $fromAddress,
        $fromName,
        $template = null,
        $archiveLocation = null
    ) {

        // TODO catch needs to handle the error rather than echo
        // TODO add else to test generate email
        if ($this->config['send'] != 'false') {
            try {
                if (is_null($template)) {
                    $template = 'email/notification.html';
                }
                $this->mail->setFrom($fromAddress, $fromName);
                foreach ($recipients as $address) {
                    $this->mail->addAddress($address);
                }
                $this->mail->Subject = $subject;
                $this->mail->Body = $this->view->render($template, $bodyData);
                $this->mail->isHTML(true);
                $this->mail->send();

                if (isset($archiveLocation)) {
                    file_put_contents($archiveLocation, $this->mail->Body);
                }
                return true;
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
