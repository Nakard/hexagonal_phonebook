<?php

namespace Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber;

use Arkon\Bundle\ApiBundle\Tests\Functional\ApiTestCase;

/**
 * Class PhoneNumberControllerTestCase
 * @package Arkon\Bundle\ApiBundle\Tests\Functional\Controller\PhoneNumber
 */
abstract class PhoneNumberControllerTestCase extends ApiTestCase
{
    /**
     * @param int $number
     * @return array
     */
    protected function createSampleNumberForRequest($number)
    {
        return [
            'number' => $number
        ];
    }

    /**
     * @return array
     */
    public function invalidNumberProvider()
    {
        return [
            'not allowed chars' => [
                $this->createSampleNumberForRequest(-123),
                file_get_contents(__DIR__ . '/responses/only_digits.json')
            ],
            'number not as int' => [
                $this->createSampleNumberForRequest('abc'),
                file_get_contents(__DIR__ . '/responses/not_int.json')
            ],
            'number too long' => [
                $this->createSampleNumberForRequest(1234567890123456),
                file_get_contents(__DIR__ . '/responses/too_big_number.json')
            ],
            'missing value' => [
                $this->createSampleNumberForRequest(''),
                file_get_contents(__DIR__ . '/responses/missing_value.json')
            ]
        ];
    }
}
