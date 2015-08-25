<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\EditPhoneNumberException;
use Arkon\Bundle\PhoneBookBundle\Exception\NotExistingPhoneNumberException;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\PhoneBookBundle\UseCase\EditPhoneNumber;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EditPhoneNumberTest
 * @package Arkon\Bundle\PhoneBookBundle\Tests\UseCase
 */
class EditPhoneNumberTest extends \PHPUnit_Framework_TestCase
{
    /** @var EditPhoneNumber */
    private $useCase;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PhoneNumberRepositoryInterface */
    private $repositoryMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ValidatorInterface */
    private $validatorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(PhoneNumberRepositoryInterface::class)->getMock();
        $this->validatorMock = $this->getMockBuilder(ValidatorInterface::class)->getMock();

        $this->useCase = new EditPhoneNumber($this->repositoryMock, $this->validatorMock);
    }

    public function testEditNumberWithDisabledValidationWillImmediatelyProceedToSave()
    {
        $number = $this->createExamplePhoneNumber();

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->with($number);

        $this->validatorMock->expects($this->never())
            ->method('validate');

        $this->useCase->editPhoneNumber($number, false);
    }

    public function testEditNotExistingNumberWillThrowNotExistingNumberException()
    {
        $this->setExpectedException(
            NotExistingPhoneNumberException::class,
            'Phone number with [id = 100] does not exist'
        );

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue(null));

        $this->useCase->editPhoneNumber($this->createExamplePhoneNumber());
    }

    public function testEditNumberValidationFailsWillThrowEditPhoneNumberException()
    {
        $this->setExpectedException(EditPhoneNumberException::class);

        $number = $this->createExamplePhoneNumber();

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue($number));

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($number)
            ->will($this->returnValue(
                new ConstraintViolationList([$this->getMockBuilder(ConstraintViolationInterface::class)->getMock()])
            ));

        $this->useCase->editPhoneNumber($number);
    }

    public function testAddNumberToUserValidationPassesWillProceedToSaveUser()
    {
        $number = $this->createExamplePhoneNumber();

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue($number));

        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($number)
            ->will($this->returnValue(new ConstraintViolationList()));

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->with($number);

        $this->useCase->editPhoneNumber($number);
    }

    /**
     * @return PhoneNumber
     */
    private function createExamplePhoneNumber()
    {
        return (new PhoneNumber())->setId(100)->setNumber(1234567890);
    }
}
