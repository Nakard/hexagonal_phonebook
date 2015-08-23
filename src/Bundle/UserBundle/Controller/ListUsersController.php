<?php

namespace Arkon\Bundle\UserBundle\Controller;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\Form\SearchUsersType;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListUsersController
 * @package Arkon\Bundle\UserBundle\Controller
 */
class ListUsersController
{
    /** @var ListUsers */
    private $useCase;

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * @param ListUsers $useCase
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(ListUsers $useCase, FormFactoryInterface $formFactory)
    {
        $this->useCase = $useCase;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @return User[]
     */
    public function listUsersAction(Request $request)
    {
        return $this->processForm($request);
    }

    /**
     * @param Request $request
     * @return View
     */
    private function processForm(Request $request)
    {
        $form = $this->formFactory->create(new SearchUsersType());
        $form->handleRequest($request);

        if (!$form->isEmpty() && !$form->isValid()) {
            return new View($form, 400);
        }

        return new View(
            $this->useCase->listUsers($form->getData()),
            200
        );
    }
}
