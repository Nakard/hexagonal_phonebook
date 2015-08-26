<?php

namespace Arkon\Bundle\ApiBundle\Controller;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UserBundle\UseCase\GetUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class GetUserController
 * @package Arkon\Bundle\ApiBundle\Controller
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
