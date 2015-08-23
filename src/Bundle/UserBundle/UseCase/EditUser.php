<?php

namespace Arkon\Bundle\UserBundle\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\EditUserException;
use Arkon\Bundle\UserBundle\Exception\NotExistingUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EditUser
 * @package Arkon\Bundle\UserBundle\UseCase
 */
class EditUser
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
    public function editUser(User $user, $validate = true)
    {
        if ($validate) {
            $this->validateUser($user);
        }

        $this->repository->save($user);
    }

    /**
     * @param User $user
     * @throws EditUserException
     *
     */
    private function validateUser(User $user)
    {
        if (!$this->repository->findById($user->getId())) {
            throw new NotExistingUserException(sprintf('User with [id = %d] does not exist', $user->getId()));
        }

        $violations = $this->validator->validate($user);
        if ($violations->count()) {
            throw new EditUserException($violations, 'Invalid User entity.');
        }
    }
}
