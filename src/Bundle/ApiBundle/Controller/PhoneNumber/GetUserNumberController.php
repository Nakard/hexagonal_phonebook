<?php

namespace Arkon\Bundle\ApiBundle\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumber;
use Arkon\Bundle\UserBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class GetUserNumberController
 * @package Arkon\Bundle\ApiBundle\Controller\PhoneNumber
 */
class GetUserNumberController
{
    /** @var GetUserNumber */
    private $useCase;

    /**
     * @param GetUserNumber $useCase
     */
    public function __construct(GetUserNumber $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * Gets user phone number object
     *
     * @ApiDoc(
     *      section="Number management",
     *      output={"class" = "Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber"},
     *      description="Gets user phone number object",
     *      statusCodes={
     *          200="Returned when successful",
     *          404={
     *               "User not found",
     *               "Number not found",
     *               "Number not belonging to user"
     *          }
     *      }
     * )
     *
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @RestView()
     * @param User $user
     * @param $numberId
     * @return PhoneNumber
     */
    public function getUserNumberAction(User $user, $numberId)
    {
        $number = $this->useCase->getUserNumber($user, $numberId);

        if (!$number) {
            throw new NotFoundHttpException('Phone number not found.');
        }

        return $number;
    }
}
