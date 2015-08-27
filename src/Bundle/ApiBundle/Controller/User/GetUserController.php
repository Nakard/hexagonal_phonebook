<?php

namespace Arkon\Bundle\ApiBundle\Controller\User;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\GetUser;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class GetUserController
 * @package Arkon\Bundle\ApiBundle\Controller\User
 */
class GetUserController
{
    /** @var GetUser */
    private $useCase;

    /**
     * @param GetUser $useCase
     */
    public function __construct(GetUser $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * Gets user object
     *
     * @ApiDoc(
     *      section="User management",
     *      output={"class" = "Arkon\Bundle\UserBundle\Entity\User"},
     *      description="Gets user object",
     *      statusCodes={
     *          200="Return when successful",
     *          404="User not found",
     *      }
     * )
     *
     * @Rest\View()
     * @param int $id
     * @return User
     */
    public function getUserAction($id)
    {
        $user = $this->useCase->getUser($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        return $user;
    }
}
