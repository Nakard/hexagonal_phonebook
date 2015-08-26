<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional;

use Arkon\Bundle\UserBundle\Tests\DataFixtures\LoadUserData;
use Arkon\Bundle\PhoneBookBundle\Tests\DataFixtures\LoadPhoneNumberData;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;

/**
 * Class ApiTestCase
 * @package Arkon\Bundle\ApiBundle\Tests\Functional
 */
class ApiTestCase extends WebTestCase
{
    /** @var Client */
    protected $client;

    /** @var JsonEncode */
    protected $jsonEncoder;

    /** @var JsonDecode */
    protected $jsonDecoder;

    protected function setUp()
    {
        parent::setUp();

        $this->client = $this->createClient(
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json']
        );
        $this->jsonDecoder = new JsonDecode(true);
        $this->jsonEncoder = new JsonEncode();

        $fixtures = [LoadUserData::class, LoadPhoneNumberData::class];
        $this->loadFixtures($fixtures);
    }

    /**
     * @param $response
     * @param int $statusCode
     */
    protected function assertJsonResponse(Response $response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode,
            $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    /**
     * @param string $data
     * @return mixed
     */
    protected function decode($data)
    {
        return $this->jsonDecoder->decode($data, 'json');
    }

    /**
     * @param mixed $data
     * @return string
     */
    protected function encode($data)
    {
        return $this->jsonEncoder->encode($data, 'json');
    }
}
