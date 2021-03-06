<?php

namespace Arkon\Bundle\ApiBundle\Controller\User;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\CreateUser;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateUserController
 * @package Arkon\Bundle\ApiBundle\Controller\User
 */
class CreateUserController
{
    /** @var CreateUser */
    private $useCase;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var RouterInterface */
    private $router;

    /**
     * @param CreateUser $useCase
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(CreateUser $useCase, FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->useCase = $useCase;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * Creates user object
     *
     * @ApiDoc(
     *      section="User management",
     *      input={"class" = "Arkon\Bundle\UserBundle\Entity\User", "name" = "", "groups" = {"add"}},
     *      output={"class" = "Arkon\Bundle\UserBundle\Entity\User"},
     *      description="Create user object",
     *      statusCodes={
                201="Returned when successful",
     *          400="Validation failed"
     *      }
     * )
     *
     * @param Request $request
     * @return View
     */
    public function createUserAction(Request $request)
    {
        return $this->processForm(new User(), $request);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return View
     */
    private function processForm(User $user, Request $request)
    {
        $form = $this->formFactory->createNamed('', 'user_create', $user);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new View($form, 400);
        }

        $this->useCase->createUser($user, false);

        return new View(
            $user,
            201,
            ['Location' => $this->router->generate('arkon_user_getUser', ['id' => $user->getId()], true)]
        );
    }
}
