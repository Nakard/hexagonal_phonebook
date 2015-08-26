<?php

namespace Arkon\Bundle\UserBundle\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\NotExistingUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;

/**
 * Class RemoveUser
 * @package Arkon\Bundle\UserBundle\UseCase
 */
class RemoveUser
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
     * @param User $user
     * @return void
     */
    public function removeUser(User $user)
    {
        if (!$this->repository->findById($user->getId())) {
            throw new NotExistingUserException(sprintf('User with [id = %d] does not exist', $user->getId()));
        }

        $this->repository->remove($user);
        $this->repository->synchronize();
    }
}
