<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\AddNumberToUserException;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\PhoneBookBundle\UseCase\AddNumberToUser;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Exception\NotExistingUserException;
use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AddNumberToUserTest
 * @package Arkon\Bundle\PhoneBookBundle\Tests\UseCase
 */
class AddNumberToUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var AddNumberToUser */
    private $useCase;

    /** @var \PHPUnit_Framework_MockObject_MockObject|UserRepositoryInterface */
    private $userRepositoryMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PhoneNumberRepositoryInterface */
    private $numberRepositoryMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ValidatorInterface */
    private $validatorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->userRepositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)->getMock();
        $this->validatorMock = $this->getMockBuilder(ValidatorInterface::class)->getMock();
        $this->numberRepositoryMock = $this->getMockBuilder(PhoneNumberRepositoryInterface::class)->getMock();

        $this->useCase = new AddNumberToUser(
            $this->userRepositoryMock,
            $this->numberRepositoryMock,
            $this->validatorMock
        );
    }

    public function testAddNumberToUserWithDisabledValidationWillImmediatelyProceedToSave()
    {
        $user = $this->createExampleUser();
        $number = $this->createExamplePhoneNumber();

        $this->numberRepositoryMock->expects($this->once())
            ->method('save')
            ->with($number);

        $this->validatorMock->expects($this->never())
            ->method('validate');

        $this->useCase->addNumberToUser($number, $user, false);
        $this->assertSame($number, $user->getPhoneNumbers()->get(0));
        $this->assertSame($user, $number->getOwner());
    }

    public function testAddNumberToNotExistingUserWillThrowNotExistingUserException()
    {
        $this->setExpectedException(NotExistingUserException::class, 'User with [id = 100] does not exist');

        $user = $this->createExampleUser();

        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue(null));

        $this->useCase->addNumberToUser($this->createExamplePhoneNumber(), $user);
    }

    public function testAddNumberToUserValidationFailsWillThrowAddNumberToUserException()
    {
        $this->setExpectedException(AddNumberToUserException::class);

        $user = $this->createExampleUser();
        $number = $this->createExamplePhoneNumber();

        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue($user));

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($number)
            ->will($this->returnValue(
                new ConstraintViolationList([$this->getMockBuilder(ConstraintViolationInterface::class)->getMock()])
            ));

        $this->useCase->addNumberToUser($number, $user);
    }

    public function testAddNumberToUserValidationPassesWillProceedToSaveUser()
    {
        $user = $this->createExampleUser();
        $number = $this->createExamplePhoneNumber();

        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue($user));

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($number)
            ->will($this->returnValue(new ConstraintViolationList()));

        $this->numberRepositoryMock->expects($this->once())
            ->method('save')
            ->with($number);

        $this->useCase->addNumberToUser($number, $user);
        $this->assertSame($number, $user->getPhoneNumbers()->get(0));
        $this->assertSame($user, $number->getOwner());
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return (new User())->setId(100);
    }

    /**
     * @return PhoneNumber
     */
    private function createExamplePhoneNumber()
    {
        return (new PhoneNumber())->setNumber(1234567890);
    }
}
