<?php

namespace Arkon\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractDbRepository
 * @package Arkon\Bundle\UserBundle\Repository
 */
abstract class AbstractDbRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function synchronize()
    {
        $this->getEntityManager()->flush();
    }
}
