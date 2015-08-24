<?php

namespace Arkon\Bundle\UserBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AbstractValidationException
 * @package Arkon\Bundle\UserBundle\Exception
 */
class AbstractValidationException extends \LogicException
{
    /** @var ConstraintViolationListInterface  */
    protected $violations;

    /**
     * @param ConstraintViolationListInterface $violations
     * {@inheritdoc}
     */
    public function __construct(
        ConstraintViolationListInterface $violations,
        $message = "",
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }
}
