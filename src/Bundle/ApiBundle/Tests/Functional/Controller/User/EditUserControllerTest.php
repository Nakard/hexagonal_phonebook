<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\User;

use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class EditUserControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\User
 */
class EditUserControllerTest extends UserControllerTestCase
{
    public function testEditNotExistingUserWillReturn404Response()
    {
        $newData = $this->createSampleUserForRequest('Test', 'User', 'Nickname');
        $this->client->request('PUT', '/users/100', [], [], [], $this->encode($newData));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testEditExistingUserWithProperDataWillReturn200Response()
    {
        $newData = $this->createSampleUserForRequest('Arek', 'Moskwa', 'Nakard');
        $this->client->request('PUT', '/users/1', [], [], [], $this->encode(['user' => $newData]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);
        $decoded = $this->decode($response->getContent());
        $this->assertSame('Arek', $decoded['first_name']);
        /** @var User $user */
        $user = $this->getObjectManager()->getRepository(User::class)->find(1);
        $this->assertSame('Arek', $user->getFirstName());
    }

    /**
     * {@inheritdoc}
     */
    public function invalidUserProvider()
    {
        return array_merge(
            parent::invalidUserProvider(),
            [
                'change nickname to other user' => [
                    $this->createSampleUserForRequest('Arek', 'Moskwa', 'baddude'),
                    file_get_contents(__DIR__ . '/responses/unique_nickname.json')
                ]
            ]
        );
    }

    /**
     * @dataProvider invalidUserProvider
     * @param array $editUser
     * @param string $expectedResponse
     */
    public function testCreateInvalidUserWillReturn400Response($editUser, $expectedResponse)
    {
        $this->client->request('PUT', '/users/1', [], [], [], $this->encode(['user' => $editUser]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 400);
        $this->assertSame(
            $this->decode($expectedResponse),
            $this->decode($response->getContent())
        );
    }
}
