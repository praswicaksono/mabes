<?php


namespace Mabes\Core\Contracts;

use Doctrine\ORM\EntityRepository;

/**
 * Interface RepositoryAwareInterface
 * @package Mabes\Core\Contracts
 */
interface RepositoryAwareInterface
{
    /**
     * @param EntityRepository $repository
     * @return mixed
     */
    public function setRepository(EntityRepository $repository);

    /**
     * @return EntityRepository
     */
    public function getRepository();
}

// EOF
