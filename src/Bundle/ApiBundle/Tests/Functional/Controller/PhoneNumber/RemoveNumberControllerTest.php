<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;

/**
 * Class RemoveNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber
 */
class RemoveNumberControllerTest extends PhoneNumberControllerTestCase
{
    public function testRemoveNotExistingNumberWillReturn404Response()
    {
        $this->client->request('DELETE', '/users/1/numbers/100');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testRemoveExistingNumberNotBelongingToSpecifiedUserWillReturn404Response()
    {
        $this->client->request('DELETE', '/users/1/numbers/3');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testRemoveExistingNumberBelongingToSpecifiedUserWillReturn204Response()
    {
        $this->client->request('DELETE', '/users/2/numbers/3');
        $response = $this->client->getResponse();

        $this->assertSame(204, $response->getStatusCode());
        $number = $this->getObjectManager()->getRepository(PhoneNumber::class)->findOneBy(['id' => 2]);
        $this->assertNull($number);
    }
}
