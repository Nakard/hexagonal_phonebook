<?php

namespace Arkon\Bundle\UserBundle\Tests\Functional\Controller;

use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class GetUserControllerTest
 * @package Arkon\Bundle\UserBundle\Tests\Functional\Controller
 */
class GetUserControllerTest extends UserControllerTestCase
{
    public function testGetNotExistingUserWillReturn404Response()
    {
        $this->client->request('GET', '/users/100');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testGetExistingUserWillReturn200Response()
    {
        $this->client->request('GET', '/users/1');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response);
        /** @var User $user */
        $user = $this->getContainer()->get('serializer')->deserialize($response->getContent(), User::class, 'json');
        $this->assertSame('Arkadiusz', $user->getFirstName());
        $this->assertSame('Moskwa', $user->getLastName());
        $this->assertSame('nakard', $user->getNickname());
    }
}
