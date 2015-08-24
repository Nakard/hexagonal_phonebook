<?php

namespace Arkon\Bundle\PhoneBookBundle\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class GetUserNumbers
 * @package Arkon\Bundle\PhoneBookBundle\UseCase
 */
class GetUserNumbers
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
     * @param User $user
     * @return PhoneNumber[]
     */
    public function getUserNumbers(User $user)
    {
        return $this->repository->findUserNumbers($user);
    }
}
