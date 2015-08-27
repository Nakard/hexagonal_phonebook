<?php

namespace Arkon\Bundle\ApiBundle\Controller\User;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\RemoveUser;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class RemoveUserController
 * @package Arkon\Bundle\ApiBundle\Controller\User
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
     * Removes user object
     *
     * @ApiDoc(
     *      section="User management",
     *      description="Removes user object",
     *      statusCodes={
     *          204="Return when successful",
     *          404="User not found",
     *      }
     * )
     *
     * @ParamConverter("user", class="ArkonUserBundle:User")
     * @View(statusCode=204)
     * @param User $user
     */
    public function removeUserAction(User $user)
    {
        $this->useCase->removeUser($user);
    }
}
