<?php

namespace Arkon\Bundle\ApiBundle\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\RemoveNumber;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class RemoveNumberController
 * @package Arkon\Bundle\ApiBundle\Controller\PhoneNumber
 */
class RemoveNumberController
{
    /** @var RemoveNumber */
    private $useCase;

    /**
     * @param RemoveNumber $useCase
     */
    public function __construct(RemoveNumber $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * Removes phone number object
     *
     * @ApiDoc(
     *      section="Number management",
     *      description="Removes phone number object",
     *      statusCodes={
     *          204="Returned when successful",
     *          404={
     *               "User not found",
     *               "Number not found",
     *               "Number not belonging to user"
     *          }
     *      }
     * )
     *
     * @ParamConverter(
     *      "phoneNumber",
     *      class="ArkonPhoneBookBundle:PhoneNumber",
     *      options={"mapping": {"id": "owner", "numberId": "id"}}
     * )
     * @View(statusCode=204)
     * @param PhoneNumber $number
     */
    public function removeNumberAction(PhoneNumber $number)
    {
        $this->useCase->removeNumber($number);
    }
}
