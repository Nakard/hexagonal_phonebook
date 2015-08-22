<?php

namespace Arkon\Bundle\UserBundle\Controller;

use Arkon\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListUsersController
 * @package Arkon\Bundle\UserBundle\Controller
 */
class ListUsersController
{
    /** @var UserRepositoryInterface  */
    private $repository;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository, EngineInterface $templating)
    {
        $this->repository = $repository;
        $this->templating = $templating;
    }

    /**
     * @param string $_format
     * @return Response
     */
    public function listUsers($_format)
    {
        $users = $this->repository->findAll();

        return $this->templating->renderResponse(
            'ArkonUserBundle::listUsers.' . $_format . '.twig',
            ['users' => $users]
        );
    }
}
