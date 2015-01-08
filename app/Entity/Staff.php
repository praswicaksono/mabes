<?php


namespace Mabes\Entity;

/**
 * @Entity
 * @Table(name="staff")
 * @HasLifecycleCallbacks
 **/

class Staff
{
    /**
     * @Id @Column(type="integer") @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $staff_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $username;

    /**
     * @Column(type="string", length=255)
     * @var string
     */
    protected $password;

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
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
     * @return bool
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param int $staff_id
     */
    public function setStaffId($staff_id)
    {
        $this->staff_id = $staff_id;
    }

    /**
     * @return int
     */
    public function getStaffId()
    {
        return $this->staff_id;
    }
}

// EOF
