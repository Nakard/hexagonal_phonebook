<?php

namespace Arkon\Bundle\UserBundle\Repository;

use Arkon\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class DbUserRepository
 * @package Arkon\Bundle\UserBundle\Repository
 */
class DbUserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function nicknameExists($nickname)
    {
        return !empty($this->findByNickname(['nickname' => $nickname]));
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function findByNickname(array $criteria)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('u.id, u.nickname')
            ->from('ArkonUserBundle:User', 'u')
            ->where('u.nickname = :nickname')
            ->setMaxResults(1)
            ->setParameter('nickname', $criteria['nickname'])
            ->getQuery()
            ->getResult();
    }
}
