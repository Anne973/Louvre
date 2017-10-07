<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 28/08/2017
 * Time: 10:38
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotClosingDayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $day=$value->format('m-d');
        if($day=='05-01' || $day=='11-01' || $day=='12-25')
        {
            $this->context->addViolation($constraint->message);
        }
    }
}