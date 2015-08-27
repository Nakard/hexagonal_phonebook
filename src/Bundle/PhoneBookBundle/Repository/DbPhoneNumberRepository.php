<?php

namespace Arkon\Bundle\PhoneBookBundle\Repository;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Repository\AbstractDbRepository;
use Doctrine\ORM\Query;

/**
 * Class DbPhoneNumberRepository
 * @package Arkon\Bundle\PhoneBookBundle\Repository
 */
class DbPhoneNumberRepository extends AbstractDbRepository implements PhoneNumberRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findByNumber(array $criteria)
    {
        return $this->createQueryBuilder('pn')
            ->select('pn.id', 'pn.number')
            ->where('pn.number = :number')
            ->setMaxResults(1)
            ->setParameter('number', $criteria['number'], \PDO::PARAM_INT)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findUserNumbers(User $user)
    {
        return $this->createQueryBuilder('pn')
            ->select('pn.id', 'pn.number')
            ->where('pn.owner = :id')
            ->setParameter('id', $user->getId(), \PDO::PARAM_INT)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findUserNumber(User $user, $numberId)
    {
        return $this->createQueryBuilder('pn')
            ->where('pn.owner = :user_id')
            ->andWhere('pn.id = :number_id')
            ->setParameter('user_id', $user->getId(), \PDO::PARAM_INT)
            ->setParameter('number_id', $numberId, \PDO::PARAM_INT)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @inheritDoc
     */
    public function save(PhoneNumber $phoneNumber)
    {
        $this->getEntityManager()->persist($phoneNumber);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->find($id);
    }

    /**
     * @inheritDoc
     */
    public function remove(PhoneNumber $number)
    {
        $this->getEntityManager()->remove($number);
    }
}
