<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 29/08/2017
 * Time: 12:42
 */

namespace AppBundle\Validator;


use AppBundle\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoTicketValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $numberTickets= $this->em
            ->getRepository (Order::class)
            ->countTickets($value->getDate());

        if($numberTickets+$value->getNumber()>Order::MAX_TICKETS_PER_DAY)
        {$this->context->buildViolation($constraint->message)->atPath('number')->addViolation();}
    }
}