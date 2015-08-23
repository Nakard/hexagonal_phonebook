<?php

namespace Arkon\Bundle\UserBundle\Repository;

use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package Arkon\Bundle\UserBundle\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return User[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user);

    /**
     * @param int $id
     * @return User
     */
    public function findById($id);

    /**
     * @param string $nickname
     * @return bool
     */
    public function nicknameExists($nickname);
}
