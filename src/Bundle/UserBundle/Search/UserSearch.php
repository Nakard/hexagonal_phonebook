<?php

namespace Arkon\Bundle\UserBundle\Search;
use Doctrine\Common\Collections\Expr\Comparison;


/**
 * Class UserSearch
 * @package Arkon\Bundle\UserBundle\Search
 */
class UserSearch
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $nickname;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserSearch
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserSearch
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return UserSearch
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * Retunrs an array of arrays in format: fieldName, operatorForSearch, fieldValue
     *
     * @return array
     */
    public function getAsComparisonDefinitions()
    {
        return [
            ['firstName', Comparison::CONTAINS, $this->getFirstName()],
            ['lastName', Comparison::CONTAINS, $this->getLastName()],
            ['nickname', Comparison::CONTAINS, $this->getNickname()]
        ];
    }
}
