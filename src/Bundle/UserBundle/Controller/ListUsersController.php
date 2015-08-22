<?php

namespace Arkon\Bundle\UserBundle\Controller;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use Arkon\Bundle\UtilityBundle\Criteria\CriteriaBuilderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListUsersController
 * @package Arkon\Bundle\UserBundle\Controller
 */
class ListUsersController
{
    /** @var ListUsers */
    private $useCase;

    /** @var CriteriaBuilderInterface */
    private $criteriaBuilder;

    /**
     * @param ListUsers $useCase
     * @param CriteriaBuilderInterface $criteriaBuilder
     */
    public function __construct(ListUsers $useCase, CriteriaBuilderInterface $criteriaBuilder)
    {
        $this->useCase = $useCase;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return User[]
     */
    public function listUsersAction(Request $request)
    {
        return $this->useCase->listUsers(
            $this->criteriaBuilder->buildCriteriaFromRequestForClass($request, User::class)
        );
    }
}
