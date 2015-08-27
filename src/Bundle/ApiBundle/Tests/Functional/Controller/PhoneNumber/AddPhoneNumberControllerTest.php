<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;

/**
 * Class AddPhoneNumberControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber
 */
class AddPhoneNumberControllerTest extends PhoneNumberControllerTestCase
{
    public function testAddNumberToNotExistingUserWillReturn404Response()
    {
        $newNumber = $this->createSampleNumberForRequest(100);
        $this->client->request('POST', '/users/100/numbers', [], [], [], $this->encode(['phoneNumber' => $newNumber]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    /**
     * {@inheritdoc}
     */
    public function invalidNumberProvider()
    {
        return array_merge(
            parent::invalidNumberProvider(),
            [
                'unique_number' => [
                    $this->createSampleNumberForRequest(694984427),
                    file_get_contents(__DIR__ . '/responses/unique_number.json')
                ]
            ]
        );
    }

    /**
     * @dataProvider invalidNumberProvider
     * @param array $newNumber
     * @param string $expectedResponse
     */
    public function testAddInvalidNumberToExistingUserWillReturn400Response(array $newNumber, $expectedResponse)
    {
        $this->client->request('POST', '/users/1/numbers', [], [], [], $this->encode(['phoneNumber' => $newNumber]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 400);
        $this->assertSame(
            $this->decode($expectedResponse),
            $this->decode($response->getContent())
        );
    }

    public function testAddValidNumberToExistingUserWillReturn201Response()
    {
        $newNumber = $this->createSampleNumberForRequest(888666111);
        $this->client->request('POST', '/users/1/numbers', [], [], [], $this->encode(['phoneNumber' => $newNumber]));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 201);
        /** @var PhoneNumber[] $numbers */
        $numbers = $this->getObjectManager()->getRepository(PhoneNumber::class)->findBy(['owner' => 1]);
        $this->assertCount(3, $numbers);
        $this->assertSame('888666111', $numbers[2]->getNumber());
        $this->assertSame(1, $numbers[2]->getOwnerId());
    }
}
