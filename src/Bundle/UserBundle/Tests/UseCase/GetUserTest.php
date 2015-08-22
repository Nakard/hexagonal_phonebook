<?php

namespace Arkon\Bundle\UserBundle\Tests\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Arkon\Bundle\UserBundle\UseCase\GetUser;

/**
 * Class GetUserTest
 * @package Arkon\Bundle\UserBundle\Tests\UseCase
 */
class GetUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetUser */
    private $useCase;

    /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)->getMock();

        $this->useCase = new GetUser($this->repositoryMock);
    }

    public function testGetUser()
    {
        $user = new User();
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->will($this->returnValue($user));

        $this->assertSame($user, $this->useCase->getUser(1));
    }
}
