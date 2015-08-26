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
 * @Hateoas\Relation(
 *      "owner",
 *      href = "expr('/users/' ~ object.getOwnerId())",
 *      exclusion = @Hateoas\Exclusion(excludeIf="expr(object.getOwner() === null)")
 * )
 *
 * @UniqueEntity(fields={"number"}, repositoryMethod="findByNumber", message="Number is already used.", groups={"add"})
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
     *      maxMessage="Phone number can't be longer than 15 digits.",
     *      groups={"add", "edit"}
     * )
     * @Assert\Type(type="integer", message="{{ value }} is not a valid number.", groups={"add", "edit"})
     * @Assert\NotBlank(message="Phone number is required.", groups={"add", "edit"})
     *
     * @JMS\Type("integer")
     */
    private $number;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Arkon\Bundle\UserBundle\Entity\User", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @JMS\Exclude()
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
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
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
