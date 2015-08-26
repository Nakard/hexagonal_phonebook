<?php

namespace Arkon\Bundle\UserBundle\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\CreateUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateUser
 * @package Arkon\Bundle\UserBundle\UseCase
 */
class CreateUser
{
    /** @var UserRepositoryInterface */
    private $repository;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param UserRepositoryInterface $repository
     * @param ValidatorInterface $validator
     */
    public function __construct(UserRepositoryInterface $repository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param User $user
     * @param bool $validate Flag used to enable validation
     */
    public function createUser(User $user, $validate = true)
    {
        if ($validate) {
            $this->validateUser($user);
        }

        $this->repository->save($user);
        $this->repository->synchronize();
    }

    /**
     * @param User $user
     * @throws CreateUserException
     */
    private function validateUser(User $user)
    {
        $violations = $this->validator->validate($user);
        if ($violations->count()) {
            throw new CreateUserException($violations, 'Invalid User entity.');
        }
    }
}
