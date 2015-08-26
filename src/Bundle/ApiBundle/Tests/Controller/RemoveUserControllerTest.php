<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller;

use Arkon\Bundle\ApiBundle\Controller\RemoveUserController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\RemoveUser;

/**
 * Class RemoveUserControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller
 */
class RemoveUserControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var RemoveUserController */
    private $controller;

    /** @var RemoveUser|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(RemoveUser::class)->disableOriginalConstructor()->getMock();

        $this->controller = new RemoveUserController($this->useCaseMock);
    }

    public function testRemoveUser()
    {
        $user = new User();

        $this->useCaseMock->expects($this->once())
            ->method('removeUser')
            ->with($user);

        $this->controller->removeUserAction($user);
    }
}
