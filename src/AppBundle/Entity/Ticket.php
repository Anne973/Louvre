<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Ticket
 *
 * @ORM\Table(name="louvre.ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;
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
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime")
     */
    private $birthdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="reduced", type="boolean")
     */
    private $reduced;


    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get reduced
     *
     * @return bool
     */
    public function getReduced()
    {
        return $this->reduced;
    }

    /**
     * Set reduced
     *
     * @param boolean $reduced
     *
     * @return Ticket
     */
    public function setReduced($reduced)
    {
        $this->reduced = $reduced;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Ticket
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Ticket
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getTarif()
    {
        $birthday = ($this->getBirthdate());
        $price = 0;
        $day = ($this->getOrder()->getDate());

        $interval = $day->diff($birthday);

        if ($interval->y < 4) {
            $price = 0;
        } elseif (($interval->y >= 4) && ($interval->y < 12)) {
            $price = 8;
        } elseif (($interval->y >= 12) && ($interval)->y < 60) {
            $price = 16;
        } elseif ($interval->y >= 60) {
            $price = 12;
        }
        if ($this->reduced === true && $price > 10) {
            $price = 10;
        }
        return $price * $this->getOrder()->getType()->getCoeff();
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Ticket
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Ticket
     */
    public function setOrder(\AppBundle\Entity\Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }
}
