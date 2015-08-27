<?php

namespace Arkon\Bundle\UserBundle\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;

/**
 * Class GetUser
 * @package Arkon\Bundle\UserBundle\UseCase
 */
class GetUser
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
     * @param integer $id
     * @return User
     */
    public function getUser($id)
    {
        return $this->repository->findById($id);
    }
}
