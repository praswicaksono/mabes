<?php


namespace Mabes\Service;

class AuthPasswordService
{
    /**
     * @var string
     */
    private $raw_password;

    /**
     * @var string
     */
    private $password;

    public function __construct($raw_password = "", $password = "")
    {
        $this->raw_password = $raw_password;
        $this->password = $password;
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

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function auth()
    {
        if ($this->password == null || $this->raw_password == null) {
            return false;
        }

        if (! password_verify($this->raw_password, $this->password)) {
            return false;
        }

        return true;
    }
}

// EOF
