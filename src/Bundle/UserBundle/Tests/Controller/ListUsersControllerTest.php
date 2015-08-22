<?php

namespace Arkon\Bundle\UserBundle\Tests\Controller;

use Arkon\Bundle\UserBundle\Controller\ListUsersController;
use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class ListUsersControllerTest
 * @package Controller
 */
class ListUsersControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ListUsersController */
    private $controller;

    /** @var EngineInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $templatingMock;

    /** @var ListUsers|\PHPUnit_Framework_MockObject_MockObject */
    private $useCaseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->templatingMock = $this->getMockBuilder(EngineInterface::class)->getMock();
        $this->useCaseMock = $this->getMockBuilder(ListUsers::class)->disableOriginalConstructor()->getMock();

        $this->controller = new ListUsersController($this->useCaseMock, $this->templatingMock);
    }

    /**
     * @return array
     */
    public function formatProvider()
    {
        return [
            ['json'],
            ['xml']
        ];
    }

    /**
     * @dataProvider formatProvider
     * @param string $format
     */
    public function testListUsersUsesPassedFormatInResponse($format)
    {
        $user = new User();
        $user->setFirstName('Wincenty')->setLastName('Kwiatek');

        $this->useCaseMock->expects($this->any())
            ->method('listUsers')
            ->will($this->returnValue([$user]));

        // Assertion for correct format used and passing of variable to template
        $this->templatingMock->expects($this->once())
            ->method('renderResponse')
            ->with(
                'ArkonUserBundle::listUsers.' . $format . '.twig',
                ['users' => [$user]]
            );

        $this->controller->listUsers($format);
    }
}
