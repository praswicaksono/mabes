<?php


namespace Mabes\Entity;


use Doctrine\ORM\EntityRepository;

class DepositRepository extends EntityRepository
{
    use CommonBehavior;

    public function save(Deposit $deposit)
    {
        $this->_em->persist($deposit);
        $this->_em->flush();
    }
}

// EOF
