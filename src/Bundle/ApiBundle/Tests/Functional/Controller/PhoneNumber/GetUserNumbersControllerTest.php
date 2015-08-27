<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Tests\Functional\ApiTestCase;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class GetUserNumbersControllerTest
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber
 */
class GetUserNumbersControllerTest extends ApiTestCase
{
    public function testGetNumbersForNonExistingUserWillReturn404Response()
    {
        $this->client->request('GET', '/users/100/numbers');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testGetNumbersForExistinUserWillReturn200ResponseWithNumbersList()
    {
        $this->client->request('GET', '/users/1/numbers');
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);
        $numbers = new ArrayCollection($this->getContainer()->get('jms_serializer')->deserialize(
            $response->getContent(),
            'array<Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber>',
            'json'
        ));

        $this->assertSame(694984427, $numbers->get(0)->getNumber());
        $this->assertSame(724489496, $numbers->get(1)->getNumber());
    }
}
