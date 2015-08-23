<?php

namespace Arkon\Bundle\UserBundle\UseCase;

use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class ListUsers
 * @package Arkon\Bundle\UserBundle\UseCase
 */
class ListUsers
{
    /** @var UserRepositoryInterface */
    private $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $criteria
     * @return User[]
     */
    public function listUsers(array $criteria = [])
    {
        return $this->repository->findBy($criteria);
    }
}