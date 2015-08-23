<?php

namespace Arkon\Bundle\UserBundle\UseCase;

use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Search\UserSearch;

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
     * @param UserSearch|null $search
     * @return User[]
     */
    public function listUsers(UserSearch $search = null)
    {
        return $this->repository->search($search);
    }
}
