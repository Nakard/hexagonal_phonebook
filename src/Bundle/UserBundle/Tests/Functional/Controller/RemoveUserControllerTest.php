<?php

namespace Arkon\Bundle\UserBundle\Tests\Functional\Controller;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class RemoveUserControllerTest
 * @package Arkon\Bundle\UserBundle\Tests\Functional\Controller
 */
class RemoveUserControllerTest extends UserControllerTestCase
{
    public function testRemoveNotExistingUserWillReturn404Response()
    {
        $this->client->request('DELETE', '/users/3');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testRemoveExistingUserWillReturn204Response()
    {
        $this->client->request('DELETE', '/users/2');
        $response = $this->client->getResponse();

        $this->assertSame(204, $response->getStatusCode());

        $user = $this->getObjectManager()->getRepository(User::class)->findOneBy(['id' => 2]);
        $this->assertNull($user);
    }
}
