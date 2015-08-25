<?php

namespace Arkon\Bundle\PhoneBookBundle\Tests\Controller;

use Arkon\Bundle\PhoneBookBundle\Controller\GetUserNumbersController;
use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumbers;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class GetUserNumbersControllerTest
 * @package Arkon\Bundle\PhoneBookBundle\Tests\Controller
 */
class GetUserNumbersControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetUserNumbersController */
    private $controller;

    /** @var GetUserNumbers|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(GetUserNumbers::class)->disableOriginalConstructor()->getMock();

        $this->controller = new GetUserNumbersController($this->useCaseMock);
    }

    public function testGetUserNumbersWillReturnNumbersFetchedFromUseCase()
    {
        $user = $this->createExampleUser();

        $numbers = [(new PhoneNumber())->setId(100), (new PhoneNumber())->setId(200)];

        $this->useCaseMock->expects($this->once())
            ->method('getUserNumbers')
            ->with($user)
            ->will($this->returnValue($numbers));

        $this->assertSame($numbers, $this->controller->getUserNumbersAction($user));
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return new User();
    }
}
