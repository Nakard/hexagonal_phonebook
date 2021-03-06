<?php

namespace Arkon\Bundle\ApiBundle\Controller\User;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\EditUser;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;

/**
 * Class EditUserController
 * @package Arkon\Bundle\ApiBundle\Controller\User
 */
class EditUserController
{
    /** @var EditUser */
    private $useCase;

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * @param EditUser $useCase
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(EditUser $useCase, FormFactoryInterface $formFactory)
    {
        $this->useCase = $useCase;
        $this->formFactory = $formFactory;
    }

    /**
     * Edits user object
     *
     * @ApiDoc(
     *      section="User management",
     *      input={"class" = "Arkon\Bundle\UserBundle\Entity\User", "name" = "", "groups" = {"edit"}},
     *      output={"class" = "Arkon\Bundle\UserBundle\Entity\User"},
     *      description="Edits user object",
     *      statusCodes={
                200="Return when successful",
     *          404="User not found",
     *          400="Validation failed"
     *      }
     * )
     *
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @param User $user
     * @param Request $request
     * @return View
     */
    public function editUserAction(User $user, Request $request)
    {
        return $this->processForm($user, $request);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return View
     */
    private function processForm(User $user, Request $request)
    {
        $form = $this->formFactory->createNamed('', 'user_edit', $user);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new View($form, 400);
        }

        $this->useCase->editUser($user, false);

        return new View(
            $user,
            200
        );
    }
}
