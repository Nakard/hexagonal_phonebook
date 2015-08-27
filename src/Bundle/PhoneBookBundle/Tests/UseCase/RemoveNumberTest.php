<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\UseCase;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\Exception\NotExistingPhoneNumberException;
use Arkon\Bundle\PhoneBookBundle\Repository\PhoneNumberRepositoryInterface;
use Arkon\Bundle\PhoneBookBundle\UseCase\RemoveNumber;

/**
 * Class RemoveNumberTest
 * @package Arkon\Bundle\PhoneBookBundle\Tests\UseCase
 */
class RemoveNumberTest extends \PHPUnit_Framework_TestCase
{
    /** @var RemoveNumber */
    private $useCase;

    /** @var PhoneNumberRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->getMockBuilder(PhoneNumberRepositoryInterface::class)->getMock();

        $this->useCase = new RemoveNumber($this->repositoryMock);
    }

    public function testRemoveNonExistingNumberWillThrowNotExistingNumberException()
    {
        $this->setExpectedException(
            NotExistingPhoneNumberException::class,
            'Phone number with [id = 100] does not exist'
        );

        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue(null));

        $this->useCase->removeNumber($this->createExampleNumber());
    }

    public function testRemoveExistingNumberWillRemoveItFromRepository()
    {
        $number = $this->createExampleNumber();
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(100)
            ->will($this->returnValue($number));

        $this->repositoryMock->expects($this->once())
            ->method('remove')
            ->with($number);

        $this->useCase->removeNumber($number);
    }

    /**
     * @return PhoneNumber
     */
    private function createExampleNumber()
    {
        return (new PhoneNumber())->setId(100);
    }
}
