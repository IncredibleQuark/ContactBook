<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Telephone
 *
 * @ORM\Table(name="telephone")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\TelephoneRepository")
 */
class Telephone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=50)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="ContactBookBundle\Entity\Contact", inversedBy="telephone")
     */
    private $contact;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Telephone
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Telephone
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set contact
     *
     * @param \ContactBookBundle\Entity\Contact $contact
     * @return Telephone
     */
    public function setContact(\ContactBookBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \ContactBookBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
