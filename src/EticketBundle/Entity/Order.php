<?php

namespace EticketBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="louvre.order")
 * @ORM\Entity(repositoryClass="EticketBundle\Repository\OrderRepository")
 */

class Order
{
    /**
     * @ORM\OneToMany(targetEntity="EticketBundle\Entity\Ticket", mappedBy="order", cascade={"persist"})
     */
    private $tickets;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="EticketBundle\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;



    public function __construct()
    {
        $this->date = new \Datetime();
        $this->tickets=new ArrayCollection();

    }
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Order
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }



    /**
     * Set type
     *
     * @param \EticketBundle\Entity\Type $type
     *
     * @return Order
     */
    public function setType(\EticketBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \EticketBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add ticket
     *
     * @param \EticketBundle\Entity\Ticket $ticket
     *
     * @return Order
     */
    public function addTicket(\EticketBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        //on lie l'annonce à la candidature
        $ticket->setOrder($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \EticketBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\EticketBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
