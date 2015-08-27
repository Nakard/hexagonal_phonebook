<?php

namespace Arkon\Bundle\PhoneBookBundle\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\NotExistingPhoneNumberException;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;

/**
 * Class RemoveNumber
 * @package Arkon\Bundle\PhoneBookBundle\UseCase
 */
class RemoveNumber
{
    /** @var PhoneNumberRepositoryInterface */
    private $repository;

    /**
     * @param PhoneNumberRepositoryInterface $repository
     */
    public function __construct(PhoneNumberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PhoneNumber $number
     * @return void
     */
    public function removeNumber(PhoneNumber $number)
    {
        if (!$this->repository->findById($number->getId())) {
            throw new NotExistingPhoneNumberException(sprintf(
                'Phone number with [id = %d] does not exist',
                $number->getId()
            ));
        }

        $this->repository->remove($number);
        $this->repository->synchronize();
    }
}
