<?php

namespace Arkon\Bundle\UtilityBundle\Criteria;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class CriteriaBuilder
 * @package Arkon\Bundle\UtilityBundle\Criteria
 */
class CriteriaBuilder implements CriteriaBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildCriteriaFromRequestForClass(Request $request, $objectOrClassFqcn)
    {
        $reflection = new \ReflectionClass($objectOrClassFqcn);
        $properties = array_flip(array_map(
            function (\ReflectionProperty $property) {
                return $property->getName();
            },
            $reflection->getProperties()
        ));

        return array_filter(
            $request->query->all(),
            function ($queryParamKey) use ($properties) {
                return isset($properties[$queryParamKey]);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
