<?php

namespace Arkon\Bundle\PhoneBookBundle\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class GetUserNumber
 * @package Arkon\Bundle\PhoneBookBundle\UseCase
 */
class GetUserNumber
{
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
     * @param int $numberId
     * @return PhoneNumber
     */
    public function getUserNumber(User $user, $numberId)
    {
        return $this->repository->findUserNumber($user, $numberId);
    }
}
