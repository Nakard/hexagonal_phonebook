<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumbers;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class GetUserNumbersTest
 * @package Arkon\Bundle\PhoneBookBundle\Tests\UseCase
 */
class GetUserNumbersTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetUserNumbers */
    private $useCase;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PhoneNumberRepositoryInterface */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(PhoneNumberRepositoryInterface::class)->getMock();

        $this->useCase = new GetUserNumbers($this->repositoryMock);
    }

    public function testGetUserNumberWillReturnFoundEntities()
    {
        $user = new User();
        $numbers = [(new PhoneNumber())->setId(100), (new PhoneNumber())->setId(200)];

        $this->repositoryMock->expects($this->once())
            ->method('findUserNumbers')
            ->with($user)
            ->will($this->returnValue($numbers));

        $this->assertSame($numbers, $this->useCase->getUserNumbers($user));
    }
}
