<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller;

use Arkon\Bundle\ApiBundle\Controller\ListUsersController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListUsersControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller
 */
class ListUsersControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ListUsersController */
    private $controller;

    /** @var ListUsers|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    /** @var FormInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $formMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(ListUsers::class)->disableOriginalConstructor()->getMock();

        $this->formMock = $this->getMockBuilder(FormInterface::class)->getMock();
        /** @var FormFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $formFactoryMock */
        $formFactoryMock = $this->getMockBuilder(FormFactoryInterface::class)->getMock();
        $formFactoryMock->expects($this->any())->method('createNamed')->will($this->returnValue($this->formMock));

        $this->useCaseMock->expects($this->any())
            ->method('listUsers')
            ->will($this->returnValue([$this->createExampleUser()]));

        $this->controller = new ListUsersController($this->useCaseMock, $formFactoryMock);
    }

    public function testListUsersWithEmptySearchFormWillPassThroughToListing()
    {
        $user = $this->createExampleUser();

        $this->formMock->expects($this->once())->method('isEmpty')->will($this->returnValue(true));
        $this->formMock->expects($this->never())->method('isValid');

        $expectedResult = new View([$user], 200);
        $this->assertEquals($expectedResult, $this->controller->listUsersAction($this->createExampleRequest()));
    }

    public function testListUsersWithInvalidSearchFormWillReturn400Response()
    {
        $this->formMock->expects($this->once())->method('isEmpty')->will($this->returnValue(false));
        $this->formMock->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $expectedResult = new View($this->formMock, 400);
        $this->assertEquals($expectedResult, $this->controller->listUsersAction($this->createExampleRequest()));
    }

    public function testListUsersForValidSearchForm()
    {
        $user = $this->createExampleUser();

        // Assertion for form validation
        $this->formMock->expects($this->once())->method('isEmpty')->will($this->returnValue(false));
        $this->formMock->expects($this->once())->method('isValid')->will($this->returnValue(true));

        $expectedResult = new View([$user], 200);
        $this->assertEquals($expectedResult, $this->controller->listUsersAction($this->createExampleRequest()));
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
