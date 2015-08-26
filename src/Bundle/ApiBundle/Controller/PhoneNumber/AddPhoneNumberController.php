<?php

namespace Arkon\Bundle\ApiBundle\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\AddNumberToUser;
use Arkon\Bundle\UserBundle\Entity\User;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AddPhoneNumberController
 * @package Arkon\Bundle\ApiBundle\Controller\PhoneNumber
 */
class AddPhoneNumberController
{
    /** @var AddNumberToUser */
    private $useCase;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var RouterInterface */
    private $router;

    /**
     * @param AddNumberToUser $useCase
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(
        AddNumberToUser $useCase,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->useCase = $useCase;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @param User $user
     * @param Request $request
     * @return View
     */
    public function addNumberAction(User $user, Request $request)
    {
        return $this->processForm(new PhoneNumber(), $user, $request);
    }

    /**
     * @param PhoneNumber $number
     * @param User $user
     * @param Request $request
     * @return View
     */
    private function processForm(PhoneNumber $number, User $user, Request $request)
    {
        $number->setOwner($user);
        $form = $this->formFactory->createNamed('phoneNumber', 'phone_number_add', $number);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new View($form, 400);
        }

        $this->useCase->addNumberToUser($number, $user, false);

        return (new View(
            $number,
            201,
            [
                'Location' => $this->router->generate(
                    'arkon_phonebook_get_user_number',
                    ['id' => $user->getId(), 'numberId' => $number->getId()],
                    true
                )
            ]
        ));
    }
}
