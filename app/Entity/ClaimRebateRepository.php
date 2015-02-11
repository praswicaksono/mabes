<?php


namespace Mabes\Entity;

use Doctrine\ORM\EntityRepository;

class ClaimRebateRepository extends EntityRepository
{
    public function save(ClaimRebate $data)
    {
        $this->_em->persist($data);
        $this->_em->flush();
    }
}

// EOF
