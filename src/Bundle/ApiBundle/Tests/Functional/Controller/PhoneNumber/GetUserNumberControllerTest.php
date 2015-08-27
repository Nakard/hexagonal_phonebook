<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Tests\Functional\ApiTestCase;

/**
 * Class GetUserNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber
 */
class GetUserNumberControllerTest extends ApiTestCase
{
    public function testGetNotExistingNumberWillReturn404Response()
    {
        $this->client->request('GET', '/users/1/numbers/100');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testGetNumberNotBelongingToSpecifiedUserWillReturn404Response()
    {
        $this->client->request('GET', '/users/1/numbers/3');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testGetExistingNumberBeloningToSpecifiedUserWillReturn200Response()
    {
        $this->client->request('GET', '/users/1/numbers/1');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response);
        $decoded = $this->decode($response->getContent());
        $this->assertSame(694984427, $decoded['number']);
    }
}
