<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Staff;
use Symfony\Component\Validator\Constraints as Assert;

class CreateStaffCommand implements CommandInterface
{
    use RepositoryAwareTrait;
    use MassAssignmentTrait;

    /**
     * @Assert\NotBlank(message="Username tidak boleh kosong")
     * @var string
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Password tidak boleh kosong")
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

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

    /**
     * @Assert\False(message="Staff email sudah ada didatabase")
     */
    public function isStaffExist()
    {
        $staff = $this->getRepository()->findOneBy(["username" => $this->getUsername()]);

        return $staff instanceof Staff ? true : false;
    }
}

// EOF
