<?php

namespace Arkon\Bundle\UserBundle\Repository;

use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package Arkon\Bundle\UserBundle\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function findAll();
}
