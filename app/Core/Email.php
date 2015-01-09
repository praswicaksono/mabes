<?php


namespace Mabes\Core;


class Email
{
    private $swiftmail;

    public function __construct()
    {
        $this->swiftmail = \Swift_Mailer::newInstance(\Swift_MailTransport::newInstance());
    }

    public static function newInstance()
    {
        return new self();
    }

    public function sendDepositNotificationEmail(array $to, array $data)
    {
        $template = file_get_contents(APP_DIR . "Template/Email/deposit.html");
        $content = $this->replaceTags($template, $data);

        $this
            ->swiftmail
            ->setSubject("Deposit Notification")
            ->setFrom(["contact@mabesforex.com" => "Mabes Forex Admin"])
            ->setTo($to)
            ->setBody($content)
            ->send();
    }

    public function sendWithdrawalNotificationEmail(array $to, array $data)
    {
        $template = file_get_contents(APP_DIR . "Template/Email/withrawal.html");
        $content = $this->replaceTags($template, $data);

        $this
            ->swiftmail
            ->setSubject("Withdrawal Notification")
            ->setFrom(["contact@mabesforex.com" => "Mabes Forex Admin"])
            ->setTo($to)
            ->setBody($content)
            ->send();
    }

    /**
     * Replace tags in template file
     *
     * @access    public
     * @param    string
     * @param    array
     * @return    string
     */
    protected function replaceTags($template_file = '', $data = array())
    {
        if (!isset($template_file) || !isset($data)) {
            return false;
        }

        // Replace tags
        foreach ($data as $key => $value) {
            $template_file = str_replace('%' . strtoupper($key) . '%', $value, $template_file);
        }

        return $template_file;
    }
}

// EOF
 