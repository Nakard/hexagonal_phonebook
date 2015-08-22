<?php

namespace Arkon\Bundle\UserBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class CreateUserException
 * @package Arkon\Bundle\UserBundle\Exception
 */
class CreateUserException extends \LogicException
{
    /** @var ConstraintViolationListInterface */
    private $violationList;

    /**
     * {@inheritdoc}
     * @param ConstraintViolationListInterface $violationList
     */
    public function __construct(
        ConstraintViolationListInterface $violationList,
        $message = "",
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->violationList = $violationList;
    }


    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolationList()
    {
        return $this->violationList;
    }
}
