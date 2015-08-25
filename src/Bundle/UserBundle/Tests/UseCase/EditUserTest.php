<?php

namespace Arkon\Bundle\UserBundle\Tests\UseCase;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\EditUserException;
use Arkon\Bundle\UserBundle\Exception\NotExistingUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Arkon\Bundle\UserBundle\UseCase\EditUser;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EditUserTest
 * @package Arkon\Bundle\UserBundle\Tests\UseCase
 */
class EditUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var EditUser */
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

        $this->useCase = new EditUser($this->repositoryMock, $this->validatorMock);
    }

    public function testEditNonExistingUserWillThrowNotExistingUserException()
    {
        $this->setExpectedException(NotExistingUserException::class);

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->will($this->returnValue(null));

        $this->useCase->editUser($this->createExampleUser());
    }

    public function testEditUserValidationFailsWillThrowEditUserException()
    {
        $this->setExpectedException(EditUserException::class);

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->will($this->returnValue($this->createExampleUser()));

        $violation = $this->getMockBuilder(ConstraintViolation::class)->disableOriginalConstructor()->getMock();

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList([$violation])));

        $this->useCase->editUser($this->createExampleUser());
    }

    public function testEditUserValidationPassesRepoWillSavePassedUser()
    {
        $user = $this->createExampleUser();

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->will($this->returnValue($this->createExampleUser()));

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->with($user);

        $this->useCase->editUser($user);
    }

    public function testEditUserWithDisabledValidationWillProceedImmediatelyToSave()
    {
        $user = $this->createExampleUser();

        $this->repositoryMock->expects($this->never())
            ->method('findById');

        $this->validatorMock->expects($this->never())
            ->method('validate');

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->with($user);

        $this->useCase->editUser($user, false);
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return new User();
    }
}
