<?php

namespace Arkon\Bundle\UserBundle\Tests\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\NotExistingUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Arkon\Bundle\UserBundle\UseCase\RemoveUser;

/**
 * Class RemoveUserTest
 * @package Arkon\Bundle\UserBundle\Tests\UseCase
 */
class RemoveUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var RemoveUser */
    private $useCase;

    /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)->getMock();

        $this->useCase = new RemoveUser($this->repositoryMock);
    }

    public function testRemoveNonExistingUserWillThrowNotExistingUserException()
    {
        $this->setExpectedException(NotExistingUserException::class);

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->will($this->returnValue(null));

        $this->useCase->removeUser($this->createExampleUser());
    }

    public function testRemoveExistingUserWillProceedWithRemovingFromRepository()
    {
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->will($this->returnValue($this->createExampleUser()));

        $this->repositoryMock->expects($this->once())
            ->method('remove');

        $this->useCase->removeUser($this->createExampleUser());
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return new User();
    }
}
