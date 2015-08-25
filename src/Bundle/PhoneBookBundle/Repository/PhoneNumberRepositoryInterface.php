<?php

namespace Arkon\Bundle\PhoneBookBundle\Repository;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Repository\RepositoryInterface;

/**
 * Interface PhoneNumberRepositoryInterface
 * @package Arkon\Bundle\PhoneBookBundle\Repository
 */
interface PhoneNumberRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $criteria
     * @return PhoneNumber[]
     */
    public function findByNumber(array $criteria);

    /**
     * @param User $user
     * @return PhoneNumber[]
     */
    public function findUserNumbers(User $user);

    /**
     * @param User $user
     * @param int $numberId
     * @return PhoneNumber
     */
    public function findUserNumber(User $user, $numberId);

    /**
     * @param PhoneNumber $phoneNumber
     * @return void
     */
    public function save(PhoneNumber $phoneNumber);

    /**
     * @param int $id
     * @return PhoneNumber
     */
    public function findById($id);
}
