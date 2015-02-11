<?php


namespace Mabes\Entity;

use Doctrine\ORM\EntityRepository;

class WithdrawalRepository extends EntityRepository
{
    use CommonBehavior;

    public function save(Withdrawal $withdrawal)
    {
        $this->_em->persist($withdrawal);
        $this->_em->flush();
    }
}

// EOF
