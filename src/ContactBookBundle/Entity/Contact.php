<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=50, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="ContactBookBundle\Entity\Address", mappedBy="contact")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="ContactBookBundle\Entity\Telephone", mappedBy="contact")
     */
    private $telephone;


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
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Contact
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Contact
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->address = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add address
     *
     * @param \ContactBookBundle\Entity\Address $address
     * @return Contact
     */
    public function addAddress(\ContactBookBundle\Entity\Address $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \ContactBookBundle\Entity\Address $address
     */
    public function removeAddress(\ContactBookBundle\Entity\Address $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add telephone
     *
     * @param \ContactBookBundle\Entity\Telephone $telephone
     * @return Contact
     */
    public function addTelephone(\ContactBookBundle\Entity\Telephone $telephone)
    {
        $this->telephone[] = $telephone;

        return $this;
    }

    /**
     * Remove telephone
     *
     * @param \ContactBookBundle\Entity\Telephone $telephone
     */
    public function removeTelephone(\ContactBookBundle\Entity\Telephone $telephone)
    {
        $this->telephone->removeElement($telephone);
    }

    /**
     * Get telephone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}
