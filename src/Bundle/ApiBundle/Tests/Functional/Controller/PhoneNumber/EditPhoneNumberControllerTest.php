<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;

/**
 * Class EditPhoneNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber
 */
class EditPhoneNumberControllerTest extends PhoneNumberControllerTestCase
{
    public function testEditNotExistingNumberWillReturn404Response()
    {
        $newNumber = $this->createSampleNumberForRequest(123);
        $this->client->request('PUT', '/users/1/numbers/100', [], [], [], $this->encode(['phoneNumber' => $newNumber]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testEditExistingNumberNotBelongingToSpecifiedUserWillReturn404Response()
    {
        $newNumber = $this->createSampleNumberForRequest(123);
        $this->client->request('PUT', '/users/1/numbers/3', [], [], [], $this->encode(['phoneNumber' => $newNumber]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testEditExisingNumberBelongingToSpecifiedUserWillReturn200Response()
    {
        $newNumber = $this->createSampleNumberForRequest(123);
        $this->client->request('PUT', '/users/1/numbers/1', [], [], [], $this->encode(['phoneNumber' => $newNumber]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);
        /** @var PhoneNumber $number */
        $number = $this->getObjectManager()->getRepository(PhoneNumber::class)->find(1);
        $this->assertSame('123', $number->getNumber());
        $this->assertSame(1, $number->getOwnerId());
    }
}
