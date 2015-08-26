<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Controller\PhoneNumber\EditPhoneNumberController;
use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\EditPhoneNumber;
use FOS\RestBundle\View\View;
use Symfony\Component\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditPhoneNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber
 */
class EditPhoneNumberControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var EditPhoneNumberController */
    private $controller;

    /** @var Form\FormInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $formMock;

    /** @var EditPhoneNumber|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    /** @var PhoneNumber */
    private $number;

    protected function setUp()
    {
        parent::setUp();

        $this->number = (new PhoneNumber())->setId(100);

        $this->formMock = $this->getMockBuilder(Form\FormInterface::class)->getMock();
        /** @var Form\FormFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $formFactoryMock */
        $formFactoryMock = $this->getMockBuilder(Form\FormFactoryInterface::class)->getMock();
        $formFactoryMock->expects($this->once())
            ->method('createNamed')
            ->with('phoneNumber', 'phone_number_edit', $this->number)
            ->will($this->returnValue($this->formMock));

        $this->useCaseMock = $this->getMockBuilder(EditPhoneNumber::class)->disableOriginalConstructor()->getMock();

        $this->controller = new EditPhoneNumberController($this->useCaseMock, $formFactoryMock);
    }

    public function testCreateUserFormDataInvalidWillReturn400Response()
    {
        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $expectedResult = new View($this->formMock, 400);

        $this->assertEquals($expectedResult, $this->controller->editPhoneNumberAction(
            $this->number,
            $this->createExampleRequest()
        ));
    }

    public function testCreateUserFormDataValidWillReturn201Response()
    {
        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->useCaseMock->expects($this->once())
            ->method('editPhoneNumber')
            ->with($this->number, false);

        $view = $this->controller->editPhoneNumberAction($this->number, $this->createExampleRequest());

        $this->assertEquals(new View($this->number, 200), $view);
    }

    /**
     * @return Request
     */
    private function createExampleRequest()
    {
        return new Request();
    }
}
