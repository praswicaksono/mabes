<?php


namespace Mabes\Service;


/**
 * Class MailerService
 * @package Mabes\Service
 */
class MailerService
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Swift_SmtpTransport
     */
    private $transport;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EmailTemplatingService
     */
    private $templating_service;

    /**
     * @var \Swift_Message
     */
    private $message;

    /**
     * @param $host
     * @param $port
     * @param $username
     * @param $password
     * @param EmailTemplatingService $templating_service
     */
    public function __construct(
        $host,
        $port,
        $username,
        $password,
        EmailTemplatingService $templating_service
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->templating_service = $templating_service;

        $this->transport = \Swift_SmtpTransport::newInstance($host, $port)
            ->setUsername($username)
            ->setPassword($password);

        $this->mailer = \Swift_Mailer::newInstance($this->transport);
    }

    /**
     * @param $subject
     * @return $this
     */
    public function createMessage($subject)
    {
        $this->message = \Swift_Message::newInstance($subject);
        $this->message->setContentType("test/html");
        return $this;
    }

    /**
     * @param $template
     * @param array $from
     * @param array $to
     * @param $data
     * @return void
     */
    public function send($template, array $from, array $to, $data)
    {
        $body = $this->templating_service->template($template, $data);

        $this->message->setFrom($from)
            ->setTo($to)
            ->setBody($body, "text/html");

        $this->mailer->send($this->message);
    }
}

// EOF
