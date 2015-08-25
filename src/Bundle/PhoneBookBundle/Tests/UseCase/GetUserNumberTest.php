<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumber;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class GetUserNumberTest
 * @package Arkon\Bundle\PhoneBookBundle\Tests\UseCase
 */
class GetUserNumberTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetUserNumber */
    private $useCase;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PhoneNumberRepositoryInterface */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(PhoneNumberRepositoryInterface::class)->getMock();

        $this->useCase = new GetUserNumber($this->repositoryMock);
    }

    public function testGetUserNumberWillReturnFoundEntity()
    {
        $user = new User();
        $number = (new PhoneNumber())->setId(100);

        $this->repositoryMock->expects($this->once())
            ->method('findUserNumber')
            ->with($user, 100)
            ->will($this->returnValue($number));

        $this->assertSame($number, $this->useCase->getUserNumber($user, $number->getId()));
    }
}
