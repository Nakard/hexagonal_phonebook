<?php

namespace Arkon\Bundle\PhoneBookBundle\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\AddNumberToUserException;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\NotExistingUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AddNumberToUser
 * @package Arkon\Bundle\PhoneBookBundle\UseCase
 */
class AddNumberToUser
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ValidatorInterface $validator
    ) {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @param User $user
     * @param bool $validate
     */
    public function addNumberToUser(PhoneNumber $phoneNumber, User $user, $validate = true)
    {
        $user->addPhoneNumber($phoneNumber);

        if ($validate) {
            $this->validateInput($user);
        }

        $this->userRepository->save($user);
    }

    /**
     * @param User $user
     * @throws NotExistingUserException
     * @throws AddNumberToUserException
     */
    private function validateInput(User $user)
    {
        if (!$this->userRepository->findById($user->getId())) {
            throw new NotExistingUserException(sprintf('User with [id = %d] does not exist', $user->getId()));
        }

        $violations = $this->validator->validate($user);
        if ($violations->count()) {
            throw new AddNumberToUserException($violations);
        }
    }
}
