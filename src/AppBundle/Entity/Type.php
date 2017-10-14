<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Type
 *
 * @ORM\Table(name="louvre_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRepository")
 */
class Type
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var float
     *
     * @ORM\Column(name="coeff", type="float")
     */
    private $coeff;


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
     * Set name
     *
     * @param string $name
     *
     * @return Type
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
     * Set coeff
     *
     * @param float $coeff
     *
     * @return Type
     */
    public function setCoeff($coeff)
    {
        $this->coeff = $coeff;

        return $this;
    }

    /**
     * Get coeff
     *
     * @return float
     */
    public function getCoeff()
    {
        return $this->coeff;
    }


}
