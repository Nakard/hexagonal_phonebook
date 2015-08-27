<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\User;
use Arkon\Bundle\UserBundle\Entity\User;

/**
 * Class CreateUserControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\User
 */
class CreateUserControllerTest extends UserControllerTestCase
{
    public function testCreateProperUserWillReturn201Response()
    {
        $newUser = $this->createSampleUserForRequest('Test', 'User', 'tester123');
        $this->client->request('POST', '/users', [], [], [], $this->encode($newUser));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 201);
        $decodedResponse = $this->jsonDecoder->decode($response->getContent(), 'json');
        $this->assertSame(4, $decodedResponse['id']);
        $this->assertContains('/users/4', $response->headers->get('location'));
        /** @var User $user */
        $user = $this->getObjectManager()->getRepository(User::class)->findOneBy(['id' => 4]);
        $this->assertSame('Test', $user->getFirstName());
        $this->assertSame('User', $user->getLastName());
        $this->assertSame('tester123', $user->getNickname());
    }

    /**
     * {@inheritdoc}
     */
    public function invalidUserProvider()
    {
        return array_merge(parent::invalidUserProvider(), [
            'unique nickname' => [
                $this->createSampleUserForRequest('Test', 'User', 'Nakard'),
                file_get_contents(__DIR__ . '/responses/unique_nickname.json')
            ]
        ]);
    }

    /**
     * @dataProvider invalidUserProvider
     * @param array $newUser
     * @param string $expectedResponse
     */
    public function testCreateInvalidUserWillReturn400Response($newUser, $expectedResponse)
    {
        $this->client->request('POST', '/users', [], [], [], $this->encode($newUser));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 400);
        $this->assertSame(
            $this->decode($expectedResponse),
            $this->decode($response->getContent())
        );
    }
}
