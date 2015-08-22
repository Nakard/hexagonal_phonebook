<?php

namespace Arkon\Bundle\UserBundle\Tests\Controller;

use Arkon\Bundle\UserBundle\Controller\ListUsersController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use Arkon\Bundle\UtilityBundle\Criteria\CriteriaBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListUsersControllerTest
 * @package Controller
 */
class ListUsersControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ListUsersController */
    private $controller;

    /** @var ListUsers|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    /** @var CriteriaBuilderInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $builderMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(ListUsers::class)->disableOriginalConstructor()->getMock();
        $this->builderMock = $this->getMockBuilder(CriteriaBuilderInterface::class)->getMock();

        $this->controller = new ListUsersController($this->useCaseMock, $this->builderMock);
    }


    public function testListUsers()
    {
        $user = new User();
        $user->setFirstName('Wincenty')->setLastName('Kwiatek');

        $this->useCaseMock->expects($this->any())
            ->method('listUsers')
            ->will($this->returnValue([$user]));
        // Assertion for filtering query params
        $this->builderMock->expects($this->once())
            ->method('buildCriteriaFromRequestForClass')
            ->will($this->returnValue([]));

        $request = new Request(['unknownfield' => 'test', 'firstName' => 'Wincenty']);

        $this->assertSame([$user], $this->controller->listUsersAction($request));
    }
}
