<?php


namespace Mabes\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Slim\Slim;

class WithdrawalRepository extends EntityRepository
{
    public function getWithdrawal($page_size = 10, $current_page = 1, $status = 0)
    {
        if ($status != 0) {
            $dql = "SELECT w FROM  Mabes\Entity\Withdrawal w where status = {$status}";
        } else {
            $dql = "SELECT w FROM Mabes\Entity\Withdrawal w";
        }

        $app = Slim::getInstance();

        $query = $app->em
            ->createQuery($dql)
            ->setFirstResult($page_size * ($current_page - 1))
            ->setMaxResults($page_size);

        $paginator = new Paginator($query);


        return $paginator;
    }
}

// EOF
