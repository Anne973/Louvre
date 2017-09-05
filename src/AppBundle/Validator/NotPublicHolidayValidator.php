<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 02/09/2017
 * Time: 18:53
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotPublicHolidayValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $day=$value->format('m-d');
        if($day=='01-01' || $day=='05-08' || $day=='07-14' || $day=='08-15' || $day=='11-11')
        {
            $this->context->addViolation($constraint->message);
        }
    }

}