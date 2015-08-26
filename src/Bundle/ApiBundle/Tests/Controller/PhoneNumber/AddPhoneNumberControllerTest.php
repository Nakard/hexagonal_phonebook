<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Controller\PhoneNumber\AddPhoneNumberController;
use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\AddNumberToUser;
use Arkon\Bundle\UserBundle\Entity\User;
use FOS\RestBundle\View\View;
use Symfony\Component\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AddPhoneNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber
 */
class AddPhoneNumberControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var AddPhoneNumberController */
    private $controller;

    /** @var Form\FormInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $formMock;

    /** @var RouterInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $routerMock;

    /** @var AddNumberToUser|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->formMock = $this->getMockBuilder(Form\FormInterface::class)->getMock();
        /** @var Form\FormFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $formFactoryMock */
        $formFactoryMock = $this->getMockBuilder(Form\FormFactoryInterface::class)->getMock();
        $formFactoryMock->expects($this->once())
            ->method('createNamed')
            ->will($this->returnValue($this->formMock));

        $this->routerMock = $this->getMockBuilder(RouterInterface::class)->getMock();

        $this->useCaseMock = $this->getMockBuilder(AddNumberToUser::class)->disableOriginalConstructor()->getMock();

        $this->controller = new AddPhoneNumberController($this->useCaseMock, $formFactoryMock, $this->routerMock);
    }

    public function testCreateUserFormDataInvalidWillReturn400Response()
    {
        $request = $this->createExampleRequest();

        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $expectedResult = new View($this->formMock, 400);

        $this->assertEquals($expectedResult, $this->controller->addNumberAction($this->createExampleUser(), $request));
    }

    public function testCreateUserFormDataValidWillReturn201Response()
    {
        $request = $this->createExampleRequest();
        $user = $this->createExampleUser();

        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->useCaseMock->expects($this->once())
            ->method('addNumberToUser');

        $this->routerMock->expects($this->once())
            ->method('generate')
            ->will($this->returnValue('http://example.com'));

        $view = $this->controller->addNumberAction($user, $request);

        $this->assertInstanceOf(PhoneNumber::class, $view->getData());
        $this->assertSame(201, $view->getStatusCode());
        $this->assertSame(['http://example.com'], $view->getHeaders()['location']);
    }

    /**
     * @return Request
     */
    private function createExampleRequest()
    {
        return new Request();
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return new User();
    }
}
