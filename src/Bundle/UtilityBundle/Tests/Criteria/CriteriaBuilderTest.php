<?php

namespace Arkon\Bundle\UtilityBundle\Tests\Criteria;

use Arkon\Bundle\UserBundle\Entity\User;
use Arkon\Bundle\UtilityBundle\Criteria\CriteriaBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CriteriaBuilderTest
 * @package Arkon\Bundle\UtilityBundle\Tests\Criteria
 */
class CriteriaBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var CriteriaBuilder */
    private $builder;

    protected function setUp()
    {
        parent::setUp();

        $this->builder = new CriteriaBuilder();
    }

    /**
     * @return array
     */
    public function builderInputProvider()
    {
        return [
            'object instance' => [new User()],
            'fqcn' => [User::class]
        ];
    }

    /**
     * @dataProvider builderInputProvider
     * @param string|object $input
     */
    public function testBuildCriteriaWithFilteringNonExistingProperties($input)
    {
        $request = $this->getExampleRequest();

        $criteria = $this->builder->buildCriteriaFromRequestForClass($request, $input);

        $this->assertSame(['firstName' => 'test'], $criteria);
    }

    /**
     * @return Request
     */
    private function getExampleRequest()
    {
        return new Request(['nonExistingProp' => 'value', 'firstName' => 'test']);
    }
}
