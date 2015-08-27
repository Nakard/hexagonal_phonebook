<?php

namespace Arkon\Bundle\UserBundle\Repository;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Search\UserSearch;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface UserRepositoryInterface
 * @package Arkon\Bundle\UserBundle\Repository
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UserSearch|null $search
     * @return User[]|ArrayCollection
     */
    public function search(UserSearch $search = null);

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user);

    /**
     * @param int $id
     * @return User|object|null
     */
    public function findById($id);

    /**
     * @param User $user
     * @return void
     */
    public function remove(User $user);
}
