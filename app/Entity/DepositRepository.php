<?php


namespace Mabes\Entity;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Slim\Slim;

class DepositRepository extends EntityRepository
{
    public function getDeposit($page_size = 10, $current_page = 1, $status = 0)
    {
        if ($status != 0) {
            $dql = "SELECT d FROM  Mabes\Entity\Deposit d where status = {$status}";
        } else {
            $dql = "SELECT d FROM Mabes\Entity\Deposit d";
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
 