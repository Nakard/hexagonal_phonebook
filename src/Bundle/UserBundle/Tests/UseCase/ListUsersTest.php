<?php

namespace Arkon\Bundle\UserBundle\Tests\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;

/**
 * Class ListUsersTest
 * @package Arkon\Bundle\UserBundle\Tests\UseCase
 */
class ListUsersTest extends \PHPUnit_Framework_TestCase
{
    /** @var ListUsers */
    private $useCase;

    /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)->getMock();

        $this->useCase = new ListUsers($this->repositoryMock);
    }

    public function testListUsers()
    {
        $user1 = new User();
        $user1->setFirstName('Wincenty')->setLastName('Kwiatek');
        $user2 = new User();
        $user2->setFirstName('Zenon')->setLastName('Majkowski');
        $expectedUsers = [$user1, $user2];

        $this->repositoryMock->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue($expectedUsers));

        $this->assertSame($expectedUsers, $this->useCase->listUsers());
    }
}
