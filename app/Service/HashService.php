<?php


namespace Mabes\Service;

class HashService
{
    private $raw_password;

    public function __construct($raw_password = "")
    {
        $this->raw_password = $raw_password;
    }

    /**
     * @return string
     */
    public function getRawPassword()
    {
        return $this->raw_password;
    }

    /**
     * @param string $raw_password
     */
    public function setRawPassword($raw_password)
    {
        $this->raw_password = $raw_password;
    }

    public function hash()
    {
        if(empty($this->raw_password)) {
            return false;
        }

        return password_hash($this->raw_password, PASSWORD_BCRYPT, ["cost" => 10]);
    }
}

// EOF
