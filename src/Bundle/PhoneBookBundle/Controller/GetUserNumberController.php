<?php

namespace Arkon\Bundle\PhoneBookBundle\Controller;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumber;
use Arkon\Bundle\UserBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class GetUserNumberController
 * @package Arkon\Bundle\PhoneBookBundle\Controller
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
