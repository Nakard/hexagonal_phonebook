<?php

namespace Arkon\Bundle\ApiBundle\Controller;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\RemoveUser;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class RemoveUserController
 * @package Arkon\Bundle\ApiBundle\Controller
 */
class RemoveUserController
{
    /** @var RemoveUser */
    private $useCase;

    /**
     * @param RemoveUser $useCase
     */
    public function __construct(RemoveUser $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @View(statusCode=204)
     * @param User $user
     */
    public function removeUserAction(User $user)
    {
        $this->useCase->removeUser($user);
    }
}
