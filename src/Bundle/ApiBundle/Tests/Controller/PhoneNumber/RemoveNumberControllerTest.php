<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Controller\PhoneNumber\RemoveNumberController;
use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\RemoveNumber;

/**
 * Class RemoveNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber
 */
class RemoveNumberControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var RemoveNumberController */
    private $controller;

    /** @var RemoveNumber|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(RemoveNumber::class)->disableOriginalConstructor()->getMock();

        $this->controller = new RemoveNumberController($this->useCaseMock);
    }

    public function testRemoveNumberActionWillDelegateRemovalToUseCase()
    {
        $number = new PhoneNumber();

        $this->useCaseMock->expects($this->once())
            ->method('removeNumber')
            ->with($number);

        $this->controller->removeNumberAction($number);
    }
}
