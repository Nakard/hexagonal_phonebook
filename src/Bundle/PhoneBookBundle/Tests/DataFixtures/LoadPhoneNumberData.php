<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\DataFixtures;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadPhoneNumberData
 * @package Arkon\Bundle\PhoneBookBundle\DataFixtures
 */
class LoadPhoneNumberData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        /** @var User $userNakard */
        $userNakard = $this->getReference('user-nakard');
        /** @var User $userDude */
        $userDude = $this->getReference('user-dude');

        $number1 = (new PhoneNumber())->setId(1)->setNumber(694984427)->setOwner($userNakard);
        $number2 = (new PhoneNumber())->setId(2)->setNumber(724489496)->setOwner($userNakard);

        $number3 = (new PhoneNumber())->setId(3)->setNumber(123456789)->setOwner($userDude);

        $manager->persist($number1);
        $manager->persist($number2);
        $manager->persist($number3);

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 2;
    }
}
