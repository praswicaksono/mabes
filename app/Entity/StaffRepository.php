<?php


namespace Mabes\Entity;

use Doctrine\ORM\EntityRepository;

class StaffRepository extends EntityRepository
{
    public function save(Staff $staff)
    {
        $this->_em->persist($staff);
        $this->_em->flush();
    }
}

// EOF
