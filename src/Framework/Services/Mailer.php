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
    private $logger;

    public function __construct($view, $mailConfig, $phpMailer, $logger)
    {
        $this->view   = $view;
        $this->config = $mailConfig;
        $this->logger = $logger;
        $this->mail   = $phpMailer;

        $this->mail->isSMTP();
        $this->mail->Host     = $this->config['host'];
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
                $message = $e->getMessage();
                $this->logger->error('Mailer threw an exception ' .  $message);
                $this->view->render('errors/error.html');
            }
        }
    }
}
