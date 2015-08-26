<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller\User;

use Arkon\Bundle\ApiBundle\Controller\User\GetUserController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\GetUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class GetUserControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller\User
 */
class GetUserControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetUserController */
    private $controller;

    /** @var GetUser|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(GetUser::class)->disableOriginalConstructor()->getMock();

        $this->controller = new GetUserController($this->useCaseMock);
    }

    public function testGetUserUseCaseWillGetUserControllerReturnsUser()
    {
        $user = new User();
        $user->setFirstName('Wincenty')->setLastName('Kwiatek');

        $this->useCaseMock->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user));

        $this->assertSame($user, $this->controller->getUserAction(1));
    }

    public function testGetUserUseCaseWontGetUserControllerThrowsNotFoundHttpException()
    {
        $this->setExpectedException(NotFoundHttpException::class);

        $this->useCaseMock->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue(null));

        $this->controller->getUserAction(1);
    }
}
