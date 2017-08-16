<?php

namespace EticketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="EticketBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\ManyToOne(targetEntity="EticketBundle\Entity\Order", inversedBy="tickets")
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
    private $reduced ;


    private $price;


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
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
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

    /**
     * Get reduced
     *
     * @return bool
     */
    public function getReduced()
    {
        return $this->reduced;
    }


    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }


    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set order
     *
     * @param \EticketBundle\Entity\Order $order
     *
     * @return Ticket
     */
    public function setOrder(\EticketBundle\Entity\Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \EticketBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
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
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
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

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getAge($birthday)
    {   $birthday=date("d/m/Y");
        $arr1 = explode('/', $birthday);
        $arr2 = explode('/', date('d/m/Y'));
        if(($arr1[1] < $arr2[1]) || (($arr1[1] == $arr2[1]) && ($arr1[0] <= $arr2[0])))
            return $arr2[2] - $arr1[2];
        else{
        return $age=$arr2[2] - $arr1[2] - 1;}
    }

    public function getTarif()
    {
        $age=$this->getAge($this->getBirthdate());
        if ($this->reduced == false)
        {
            if($age<4){return 0;}
            elseif(($age>=4)&&($age<12)){return 8;}
            elseif(($age>=12)&&($age)<60){return 16;}
            elseif($age>=60){return 12;}
        }

        else {return 10;}
    }

}
