<?php

namespace Arkon\Bundle\UserBundle\Tests\Controller;

use Arkon\Bundle\UserBundle\Controller\CreateUserController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\CreateUser;
use FOS\RestBundle\View\View;
use Symfony\Component\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateUserControllerTest
 * @package Arkon\Bundle\UserBundle\Tests\Controller
 */
class CreateUserControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var CreateUserController */
    private $controller;

    /** @var Form\FormInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $formMock;

    /** @var RouterInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $routerMock;

    protected function setUp()
    {
        parent::setUp();

        $this->formMock = $this->getMockBuilder(Form\FormInterface::class)->getMock();
        /** @var Form\FormFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $formFactoryMock */
        $formFactoryMock = $this->getMockBuilder(Form\FormFactoryInterface::class)->getMock();
        $formFactoryMock->expects($this->any())
            ->method('create')
            ->will($this->returnValue($this->formMock));

        $this->routerMock = $this->getMockBuilder(RouterInterface::class)->getMock();
        /** @var CreateUser|\PHPUnit_Framework_MockObject_MockObject $useCaseMock */
        $useCaseMock = $this->getMockBuilder(CreateUser::class)->disableOriginalConstructor()->getMock();

        $this->controller = new CreateUserController($useCaseMock, $formFactoryMock, $this->routerMock);
    }

    public function testCreateUserFormDataInvalidWillReturn400Response()
    {
        $request = $this->createExampleRequest();

        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $expectedResult = new View($this->formMock, 400);

        $this->assertEquals($expectedResult, $this->controller->createUserAction($request));
    }

    public function testCreateUserFormDataValidWillReturn201Response()
    {
        $request = $this->createExampleRequest();

        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->routerMock->expects($this->once())
            ->method('generate')
            ->will($this->returnValue('http://example.com'));

        $view = $this->controller->createUserAction($request);

        $this->assertInstanceOf(User::class, $view->getData());
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
}
