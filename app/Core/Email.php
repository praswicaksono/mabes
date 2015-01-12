<?php


namespace Mabes\Core;


class Email
{
    const EMAIL_DEPOSIT = 1;

    const EMAIL_WITHDRAWAL = 2;

    private $swiftmail;

    public function __construct()
    {
        $this->swiftmail = \Swift_Mailer::newInstance(\Swift_MailTransport::newInstance());
    }

    public static function newInstance()
    {
        return new self();
    }

    public function sendEmail($type, array $data)
    {
        $template_file = ($type == $this::EMAIL_DEPOSIT) ? "deposit.html" : "withdrawal.html";

        $template = file_get_contents(APP_DIR . "Template/Email/" . $template_file);
        $content = $this->replaceTags($template, $data["body"]);

        $this
            ->swiftmail
            ->setSubject($data["subject"])
            ->setFrom(["contact@mabesforex.com" => "Mabes Forex Admin"])
            ->setTo($data["to"])
            ->setBody($content)
            ->send();
    }

    /**
     * Replace tags in template file
     *
     * @access public
     * @param string
     * @param array
     * @return string
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
