<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 27/08/2017
 * Time: 15:37
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotTuesdayValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $day=$value->format('l');
        if($day == "Tuesday"){
            $this->context->addViolation($constraint-> message);
        }
    }
}