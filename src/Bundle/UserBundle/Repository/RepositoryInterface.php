<?php

namespace Arkon\Bundle\UserBundle\Repository;

/**
 * Interface RepositoryInterface
 * @package Arkon\Bundle\UserBundle\Repository
 */
interface RepositoryInterface
{
    /**
     * Synchronizes the in-memory state of managed objects with the data storage.
     */
    public function synchronize();
}
