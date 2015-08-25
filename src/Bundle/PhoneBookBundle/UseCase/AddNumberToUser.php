<?php

namespace Arkon\Bundle\PhoneBookBundle\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\AddNumberToUserException;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
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

    /** @var PhoneNumberRepositoryInterface */
    private $numberRepository;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param PhoneNumberRepositoryInterface $numberRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        PhoneNumberRepositoryInterface $numberRepository,
        ValidatorInterface $validator
    ) {
        $this->userRepository = $userRepository;
        $this->numberRepository = $numberRepository;
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
        $phoneNumber->setOwner($user);

        if ($validate) {
            $this->validateInput($phoneNumber, $user);
        }

        $this->numberRepository->save($phoneNumber);
        $this->numberRepository->synchronize();
    }

    /**
     * @param PhoneNumber $number
     * @param User $user
     * @throws NotExistingUserException
     * @throws AddNumberToUserException
     */
    private function validateInput(PhoneNumber $number, User $user)
    {
        if (!$this->userRepository->findById($user->getId())) {
            throw new NotExistingUserException(sprintf('User with [id = %d] does not exist', $user->getId()));
        }

        $violations = $this->validator->validate($number);
        if ($violations->count()) {
            throw new AddNumberToUserException($violations);
        }
    }
}
