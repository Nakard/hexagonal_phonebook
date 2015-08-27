<?php

namespace Arkon\Bundle\ApiBundle\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\EditPhoneNumber;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditPhoneNumberController
 * @package Arkon\Bundle\ApiBundle\Controller\PhoneNumber
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
     * Edits phone number object
     *
     * @ApiDoc(
     *      section="Number management",
     *      input={"class" = "Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber", "name" = "", "groups" = {"edit"}},
     *      output={"class" = "Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber"},
     *      description="Edits phone number object",
     *      statusCodes={
     *          200="Returned when successful",
     *          400="Validation failed",
     *          404={
     *               "User not found",
     *               "Number not found"
     *          }
     *      }
     * )
     *
     * @ParamConverter(
     *      "phoneNumber",
     *      class="ArkonPhoneBookBundle:PhoneNumber",
     *      options={"mapping": {"id": "owner", "numberId": "id"}}
     * )
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
        $form = $this->formFactory->createNamed('', 'phone_number_edit', $phoneNumber);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new View($form, 400);
        }

        $this->useCase->editPhoneNumber($phoneNumber, false);

        return new View($phoneNumber, 200);
    }
}
