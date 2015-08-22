<?php

namespace Arkon\Bundle\UserBundle\Tests\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\CreateUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Arkon\Bundle\UserBundle\UseCase\CreateUser;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateUserTest
 * @package Arkon\Bundle\UserBundle\Tests\UseCase
 */
class CreateUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var CreateUser */
    private $useCase;

    /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $repositoryMock;

    /** @var ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $validatorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)->getMock();
        $this->validatorMock = $this->getMockBuilder(ValidatorInterface::class)->getMock();

        $this->useCase = new CreateUser($this->repositoryMock, $this->validatorMock);
    }

    public function testCreateUserValidationFailsWillThrowCreateUserException()
    {
        $this->setExpectedException(CreateUserException::class);

        $violation = $this->getMockBuilder(ConstraintViolation::class)->disableOriginalConstructor()->getMock();

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList([$violation])));

        $this->useCase->createUser(new User());
    }

    public function testCreateUserValidationPassesRepoWillSavePassedUser()
    {
        $user = $this->createExampleUser();

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->with($user);

        $this->useCase->createUser($user);
    }

    public function testCreateUserWithDisabledValidationWillProceedImmediatelyToSave()
    {
        $user = $this->createExampleUser();

        $this->validatorMock->expects($this->never())
            ->method('validate');

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->with($user);

        $this->useCase->createUser($user, false);
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return new User();
    }
}
