<?php

namespace Arkon\Bundle\UserBundle\Tests\DataFixtures;

use Arkon\Bundle\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 * @package Arkon\Bundle\UserBundle\DataFixtures
 */
class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user1 = (new User())->setId(1)
            ->setFirstName('Arkadiusz')
            ->setLastName('Moskwa')
            ->setNickname('nakard');

        $user2 = (new User())->setId(2)
            ->setFirstName('Imaginary')
            ->setLastName('Friend')
            ->setNickname('baddude');

        $user3 = (new User())->setId(3)
            ->setFirstName('Janusz')
            ->setLastName('Jarzyna')
            ->setNickname('abrakadabra');

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);

        $manager->flush();

        $this->addReference('user-nakard', $user1);
        $this->addReference('user-dude', $user2);
    }

    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 1;
    }
}
