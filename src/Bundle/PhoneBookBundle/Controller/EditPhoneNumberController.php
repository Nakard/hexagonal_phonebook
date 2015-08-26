<?php

namespace Arkon\Bundle\PhoneBookBundle\Controller;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\EditPhoneNumber;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditPhoneNumberController
 * @package Arkon\Bundle\PhoneBookBundle\Controller
 */
class EditPhoneNumberController
{
    /** @var EditPhoneNumber */
    private $useCase;

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * @param EditPhoneNumber $useCase
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(EditPhoneNumber $useCase, FormFactoryInterface $formFactory)
    {
        $this->useCase = $useCase;
        $this->formFactory = $formFactory;
    }

    /**
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @ParamConverter("phoneNumber", class="ArkonPhoneBookBundle:PhoneNumber", options={"id" = "numberId"})
     * @param PhoneNumber $phoneNumber
     * @param Request $request
     * @return View
     */
    public function editPhoneNumberAction(PhoneNumber $phoneNumber, Request $request)
    {
        return $this->processForm($phoneNumber, $request);
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @param Request $request
     * @return View
     */
    private function processForm(PhoneNumber $phoneNumber, Request $request)
    {
        $form = $this->formFactory->createNamed('phoneNumber', 'phone_number_edit', $phoneNumber);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new View($form, 400);
        }

        $this->useCase->editPhoneNumber($phoneNumber, false);

        return new View($phoneNumber, 200);
    }
}
