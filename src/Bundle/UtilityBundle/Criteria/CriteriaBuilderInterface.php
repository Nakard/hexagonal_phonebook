<?php

namespace Arkon\Bundle\UtilityBundle\Criteria;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface CriteriaBuilderInterface
 * @package Arkon\Bundle\UtilityBundle\Criteria
 */
interface CriteriaBuilderInterface
{
    /**
     * @param Request $request
     * @param object|string $objectOrClassFqcn
     * @return array
     */
    public function buildCriteriaFromRequestForClass(Request $request, $objectOrClassFqcn);
}
