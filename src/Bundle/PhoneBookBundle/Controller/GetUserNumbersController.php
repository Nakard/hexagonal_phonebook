<?php

namespace Arkon\Bundle\PhoneBookBundle\Controller;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Arkon\Bundle\PhoneBookBundle\UseCase\GetUserNumbers;
use Arkon\Bundle\UserBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class GetUserNumbersController
 * @package Arkon\Bundle\PhoneBookBundle\Controller
 */
class GetUserNumbersController
{
    /** @var GetUserNumbers */
    private $useCase;

    /**
     * @param GetUserNumbers $useCase
     */
    public function __construct(GetUserNumbers $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @RestView()
     * @param User $user
     * @return PhoneNumber[]
     */
    public function getUserNumbersAction(User $user)
    {
        return $this->useCase->getUserNumbers($user);
    }
}
