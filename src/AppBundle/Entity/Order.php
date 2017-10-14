<?php

namespace AppBundle\Entity;
use AppBundle\Validator\NotClosingDay;
use AppBundle\Validator\NotPublicHoliday;
use AppBundle\Validator\NotSunday;
use AppBundle\Validator\NoTicket;
use AppBundle\Validator\NotTuesday;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Order
 *
 * @ORM\Table(name="louvre_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 * @NoTicket()
 */

class Order
{
    const MAX_TICKETS_PER_DAY = 1000;

    const MAX_HOUR_FOR_FULL_DAY = '14';
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="order", cascade={"persist"})
     * @Assert\Valid()
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
     * @Assert\NotBlank()
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today")
     * @NotTuesday()
     * @NotSunday()
     * @NotClosingDay()
     * @NotPublicHoliday()
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     *     )
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     * @ORM\Column(name="stripe", type="string", length=255)
     */
    private $stripe;

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
     * @param \AppBundle\Entity\Type $type
     *
     * @return Order
     */
    public function setType(\AppBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Order
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        //on lie l'annonce à la candidature
        $ticket->setOrder($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return ArrayCollection|Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    public function getTarif()
    {
        $prix = 0;
        foreach ($this->getTickets()as $ticket)
        {

            $prix += $ticket->getTarif();
        }
        return $prix;

}

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Order
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @Assert\Callback
     */

    public function validate(ExecutionContextInterface $context,$payload)
    {

            $today = new \DateTime;
            if (($this->date->format('Y-m-d') == $today->format('Y-m-d')) && ($today->format('H') >= self::MAX_HOUR_FOR_FULL_DAY)) {
                if ($this->getType()->getName() == "journée")
                {
                    $context
                    ->buildViolation('vous ne pouvez pas réserver un billet journée')
                    ->atPath('type')
                    ->addViolation();

            }
        }
    }



    /**
     * Set stripe
     *
     * @param string $stripe
     *
     * @return Order
     */
    public function setStripe($stripe)
    {
        $this->stripe = $stripe;

        return $this;
    }

    /**
     * Get stripe
     *
     * @return string
     */
    public function getStripe()
    {
        return $this->stripe;
    }
}
