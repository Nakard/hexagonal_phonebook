<?php

namespace Arkon\Bundle\UserBundle\Tests\Controller;

use Arkon\Bundle\UserBundle\Controller\EditUserController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\EditUser;
use FOS\RestBundle\View\View;
use Symfony\Component\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditUserControllerTest
 * @package Arkon\Bundle\UserBundle\Tests\Controller
 */
class EditUserControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var EditUserController */
    private $controller;

    /** @var Form\FormInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $formMock;

    protected function setUp()
    {
        parent::setUp();

        $this->formMock = $this->getMockBuilder(Form\FormInterface::class)->getMock();
        /** @var Form\FormFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $formFactoryMock */
        $formFactoryMock = $this->getMockBuilder(Form\FormFactoryInterface::class)->getMock();
        $formFactoryMock->expects($this->any())
            ->method('create')
            ->will($this->returnValue($this->formMock));

        /** @var EditUser|\PHPUnit_Framework_MockObject_MockObject $useCaseMock */
        $useCaseMock = $this->getMockBuilder(EditUser::class)->disableOriginalConstructor()->getMock();

        $this->controller = new EditUserController($useCaseMock, $formFactoryMock);
    }

    public function testCreateUserFormDataInvalidWillReturn400Response()
    {
        $request = $this->createExampleRequest();
        $user = $this->createExampleUser();

        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $expectedResult = new View($this->formMock, 400);

        $this->assertEquals($expectedResult, $this->controller->editUserAction($user, $request));
    }

    public function testCreateUserFormDataValidWillReturn204Response()
    {
        $request = $this->createExampleRequest();
        $user = $this->createExampleUser();

        $this->formMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $view = $this->controller->editUserAction($user, $request);

        $this->assertInstanceOf(User::class, $view->getData());
        $this->assertSame(204, $view->getStatusCode());
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
