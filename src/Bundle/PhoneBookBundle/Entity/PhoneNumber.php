<?php

namespace Arkon\Bundle\PhoneBookBundle\Entity;

use Arkon\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PhoneNumber
 * @package Arkon\Bundle\PhoneBookBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Arkon\Bundle\PhoneBookBundle\Repository\DbPhoneNumberRepository")
 * @ORM\Table(name="phone_numbers", indexes={@ORM\Index(name="number_idx", columns={"number"})})
 *
 * @Hateoas\Relation("self", href="expr('/users/' ~ object.getOwnerId() ~ '/numbers/' ~ object.getId())")
 *
 * @UniqueEntity(fields={"number"}, repositoryMethod="findByNumber", message="Number is already used.")
 */
class PhoneNumber
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     *
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="bigint")
     *
     * @Assert\Range(
     *      min="0",
     *      minMessage="Phone number can contain only digits.",
     *      max="999999999999999",
     *      maxMessage="Phone number can't be longer than 15 digits.")
     * @Assert\Type(type="integer", message="{{ value }} is not a valid number.")
     * @Assert\NotNull(message="Phone number is required.")
     *
     * @JMS\Type("string")
     */
    private $number;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Arkon\Bundle\UserBundle\Entity\User", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @JMS\Type("Arkon\Bundle\UserBundle\Entity\User")
     */
    private $owner;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->getOwner()->getId();
    }
}
