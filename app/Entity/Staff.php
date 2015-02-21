<?php


namespace Mabes\Entity;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;

/**
 * @Entity(repositoryClass="StaffRepository")
 * @Table(name="staff")
 * @HasLifecycleCallbacks
 **/

class Staff
{
    use MassAssignmentTrait;
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
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
