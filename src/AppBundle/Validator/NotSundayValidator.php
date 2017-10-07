<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 28/08/2017
 * Time: 10:20
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotSundayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $day=$value->format('l');
        if($day == "Sunday"){
        $this->context->addViolation($constraint-> message);
         }
    }
}