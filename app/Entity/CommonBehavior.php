<?php


namespace Mabes\Entity;

use Slim\Slim;
use Doctrine\ORM\Tools\Pagination\Paginator;

trait CommonBehavior
{
    public function query($dql, $page_size = 10, $current_page = 1)
    {
        $app = Slim::getInstance();

        $query = $app->em
            ->createQuery($dql)
            ->setFirstResult($page_size * ($current_page - 1))
            ->setMaxResults($page_size);

        $paginator = new Paginator($query);

        return $paginator;
    }
}

//EOF
