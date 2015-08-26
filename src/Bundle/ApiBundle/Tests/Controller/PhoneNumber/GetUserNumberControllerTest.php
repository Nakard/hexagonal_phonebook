<?php

namespace Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Controller\PhoneNumber\GetUserNumberController;
use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumber;
use Arkon\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class GetUserNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Controller\PhoneNumber
 */
class GetUserNumberControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetUserNumberController */
    private $controller;

    /** @var GetUserNumber|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->useCaseMock = $this->getMockBuilder(GetUserNumber::class)->disableOriginalConstructor()->getMock();

        $this->controller = new GetUserNumberController($this->useCaseMock);
    }

    public function testGetUserNonExistingNumberWillThrowHttpNotFoundException()
    {
        $this->setExpectedException(NotFoundHttpException::class, 'Phone number not found.');

        $user = $this->createExampleUser();
        $numberId = 100;

        $this->useCaseMock->expects($this->once())
            ->method('getUserNumber')
            ->with($user, $numberId)
            ->will($this->returnValue(null));

        $this->controller->getUserNumberAction($user, $numberId);
    }

    public function testGetUserExistingNumberWillReturnThatNumber()
    {
        $user = $this->createExampleUser();
        $number = (new PhoneNumber())->setId(100);

        $this->useCaseMock->expects($this->once())
            ->method('getUserNumber')
            ->with($user, $number->getId())
            ->will($this->returnValue($number));

        $this->assertSame($number, $this->controller->getUserNumberAction($user, $number->getId()));
    }

    /**
     * @return User
     */
    private function createExampleUser()
    {
        return new User();
    }
}
