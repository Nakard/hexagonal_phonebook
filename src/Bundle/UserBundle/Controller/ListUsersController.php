<?php

namespace Arkon\Bundle\UserBundle\Controller;

use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListUsersController
 * @package Arkon\Bundle\UserBundle\Controller
 */
class ListUsersController
{
    /** @var ListUsers  */
    private $useCase;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param ListUsers $useCase
     * @param EngineInterface $templating
     */
    public function __construct(ListUsers $useCase, EngineInterface $templating)
    {
        $this->useCase = $useCase;
        $this->templating = $templating;
    }

    /**
     * @param string $_format
     * @return Response
     */
    public function listUsers($_format)
    {
        $users = $this->useCase->listUsers();

        return $this->templating->renderResponse(
            'ArkonUserBundle::listUsers.' . $_format . '.twig',
            ['users' => $users]
        );
    }
}
