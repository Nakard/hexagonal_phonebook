<?php

namespace Arkon\Bundle\PhoneBookBundle\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\EditPhoneNumberException;
use Arkon\Bundle\PhoneBookBundle\Exception\NotExistingPhoneNumberException;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EditPhoneNumber
 * @package Arkon\Bundle\PhoneBookBundle\UseCase
 */
class EditPhoneNumber
{
    /** @var PhoneNumberRepositoryInterface */
    private $repository;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param PhoneNumberRepositoryInterface $repository
     * @param ValidatorInterface $validator
     */
    public function __construct(PhoneNumberRepositoryInterface $repository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @param bool|true $validate
     */
    public function editPhoneNumber(PhoneNumber $phoneNumber, $validate = true)
    {
        if ($validate) {
            $this->validatePhoneNumber($phoneNumber);
        }

        $this->repository->save($phoneNumber);
        $this->repository->synchronize();
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @throws NotExistingPhoneNumberException
     * @throws EditPhoneNumberException
     */
    private function validatePhoneNumber(PhoneNumber $phoneNumber)
    {
        if (!$this->repository->findById($phoneNumber->getId())) {
            throw new NotExistingPhoneNumberException(sprintf(
                'Phone number with [id = %d] does not exist.',
                $phoneNumber->getId()
            ));
        }

        $violations = $this->validator->validate($phoneNumber);
        if ($violations->count()) {
            throw new EditPhoneNumberException($violations);
        }
    }
}
