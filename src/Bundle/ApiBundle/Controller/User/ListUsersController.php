<?php

namespace Arkon\Bundle\ApiBundle\Controller\User;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\ListUsers;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListUsersController
 * @package Arkon\Bundle\ApiBundle\Controller\User
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
     * Fetches list of users
     *
     * @ApiDoc(
     *      section="User management",
     *      input={"class" = "user_search", "name": ""},
     *      output={"class" = "array<Arkon\Bundle\UserBundle\Entity\User>"},
     *      description="Fetches list of users",
     *      statusCodes={
     *          200="Return when successful"
     *      }
     * )
     *
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
        $form = $this->formFactory->createNamed('', 'user_search');
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
