<?php

namespace Arkon\Bundle\UserBundle\Entity;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package Arkon\Bundle\UserBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Arkon\Bundle\UserBundle\Repository\DbUserRepository")
 * @ORM\Table("users", indexes={@ORM\Index(name="nickname_idx", columns={"nickname"})})
 *
 * @UniqueEntity(
 *      fields={"nickname"},
 *      repositoryMethod="findByNickname",
 *      message="Nickname is already used.",
 *      groups={"unique"}
 * )
 *
 * @Hateoas\Relation("self", href="expr('/users/' ~ object.getId())")
 *
 * @JMS\XmlRoot("user")
 */
class User
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
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\Length(
     *      min="3",
     *      max="50",
     *      minMessage="First name can't be shorter than 3 letters.",
     *      maxMessage="First name can't be longer than 50 letters."
     * )
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="First name can only contain letters.")
     * @Assert\Type(type="string", message="{{ value }} is not a string.")
     * @Assert\NotNull(message="First name is required.")
     *
     * @JMS\Type("string")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\Length(
     *      min="3",
     *      max="50",
     *      minMessage="Last name can't be shorter than 3 letters.",
     *      maxMessage="Last name can't be longer than 50 letters."
     * )
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="Last name can only contain letters.")
     * @Assert\Type(type="string", message="{{ value }} is not a string.")
     * @Assert\NotNull(message="Last name is required.")
     *
     * @JMS\Type("string")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(
     *      min="5",
     *      max="100",
     *      minMessage="Nickname can't be shorter than 5 letters.",
     *      maxMessage="Nickname can't be longer than 100 letters."
     * )
     * @Assert\Regex(pattern="/^[a-z0-9]+$/i", message="Nickname can contain only letters and digits.")
     * @Assert\Type(type="string", message="{{ value }} is not a string.")
     * @Assert\NotNull(message="Nickname is required.")
     *
     * @JMS\Type("string")
     */
    private $nickname;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber",
     *      mappedBy="owner",
     *      cascade={"persist"}
     * )
     *
     * @Assert\Valid()
     *
     * @JMS\Type("ArrayCollection<Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber>")
     */
    private $phoneNumbers;

    /**
     * Init
     */
    public function __construct()
    {
        $this->phoneNumbers = new ArrayCollection();
    }

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return $this
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers->add($phoneNumber);
        $phoneNumber->setOwner($this);
        return $this;
    }
}
