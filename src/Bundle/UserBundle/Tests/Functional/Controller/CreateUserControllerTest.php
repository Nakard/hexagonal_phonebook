<?php

namespace Arkon\Bundle\UserBundle\Tests\Functional\Controller;

/**
 * Class CreateUserControllerTest
 * @package Arkon\Bundle\UserBundle\Tests\Functional\Controller
 */
class CreateUserControllerTest extends UserControllerTestCase
{
    public function testCreateProperUserWillReturn201Response()
    {
        $newUser = $this->createSampleUserForRequest('Test', 'User', 'tester123');
        $this->client->request('POST', '/users', [], [], [], $this->encode(['user' => $newUser]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 201);
        $decodedResponse = $this->jsonDecoder->decode($response->getContent(), 'json');
        $this->assertSame(3, $decodedResponse['id']);
        $this->assertContains('/users/3', $response->headers->get('location'));
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
        $this->client->request('POST', '/users', [], [], [], $this->encode(['user' => $newUser]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 400);
        $this->assertSame(
            $this->jsonDecoder->decode($expectedResponse, 'json'),
            $this->jsonDecoder->decode($response->getContent(), 'json')
        );
    }
}
