<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller;

use Arkon\Bundle\ApiBundle\Tests\Functional\ApiTestCase;

/**
 * Class UserControllerTestCase
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller
 */
abstract class UserControllerTestCase extends ApiTestCase
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $nickname
     * @return array
     */
    protected function createSampleUserForRequest($firstName, $lastName, $nickname)
    {
        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'nickname' => $nickname
        ];
    }

    /**
     * @return array
     */
    public function invalidUserProvider()
    {
        return [
            'missing field' => [
                $this->createSampleUserForRequest('test', 'test', null),
                file_get_contents(__DIR__ . '/responses/missing_field.json')
            ],
            'field too short' => [
                $this->createSampleUserForRequest('Al', 'Bundy', 'bundies'),
                file_get_contents(__DIR__ . '/responses/name_too_short.json')
            ],
            'field too long' => [
                $this->createSampleUserForRequest(
                    'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod',
                    'Bundy',
                    'bundies'
                ),
                file_get_contents(__DIR__ . '/responses/name_too_long_unallowed_characters.json')
            ]
        ];
    }
}
