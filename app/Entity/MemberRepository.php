<?php


namespace Mabes\Entity;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
    public function save(Member $member)
    {
        $this->_em->persist($member);
        $this->_em->flush();
    }
}

// EOF
