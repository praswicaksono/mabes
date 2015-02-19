<?php


namespace Mabes\Entity;

use Doctrine\ORM\EntityRepository;

class InvestorPasswordRepository extends EntityRepository
{
    public function save(InvestorPassword $investor_password)
    {
        $this->_em->persist($investor_password);
        $this->_em->flush();
    }
}

// EOF
