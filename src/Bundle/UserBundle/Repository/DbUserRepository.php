<?php

namespace Arkon\Bundle\UserBundle\Repository;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Search\UserSearch;
use Doctrine\Common\Collections;

/**
 * Class DbUserRepository
 * @package Arkon\Bundle\UserBundle\Repository
 */
class DbUserRepository extends AbstractDbRepository implements UserRepositoryInterface
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
        return !empty($this->checkForUniqueNickname(['nickname' => $nickname]));
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function checkForUniqueNickname(array $criteria)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.nickname')
            ->where('u.nickname = :nickname')
            ->andWhere('u.id != :id')
            ->setMaxResults(1)
            ->setParameter('nickname', $criteria['nickname'], \PDO::PARAM_STR)
            ->setParameter('id', $criteria['id'], \PDO::PARAM_INT)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function search(UserSearch $search = null)
    {
        return $this->matching($this->buildCriteriaFromSearch($search));
    }

    /**
     * @param UserSearch|null $search
     * @return Collections\Criteria
     */
    private function buildCriteriaFromSearch(UserSearch $search = null)
    {
        $criteria = new Collections\Criteria();
        if (!isset($search)) {
            return $criteria;
        }

        foreach ($search->getAsComparisonDefinitions() as $definition) {
            list($fieldName, $comparisonOperator, $fieldValue) = $definition;
            if (!isset($fieldValue)) { // ignore nulls in search form
                continue;
            }
            $criteria->andWhere(new Collections\Expr\Comparison($fieldName, $comparisonOperator, $fieldValue));
        }

        return $criteria;
    }
}
