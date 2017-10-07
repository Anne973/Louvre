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

        $easterDay=easter_date($value->format('Y'));

        $date =new \DateTime();
        $date->setTimestamp($easterDay);
        $easterDate=(new \DateTime($date->format('Y-m-d')))->modify('+ 1 day');
        $ascensionDate=(new \DateTime($date->format('Y-m-d')))->modify('+ 39 day');
        $pentecostDate=(new \DateTime($date->format('Y-m-d')))->modify('+ 50 day');


        if($day=='01-01' || $day=='05-08' || $day=='07-14' || $day=='08-15' || $day=='11-11'
            || $day==$easterDate->format('m-d')
                || $day==$ascensionDate->format('m-d')
                    || $day==$pentecostDate->format('m-d'))
        {
            $this->context->addViolation($constraint->message);
        }

    }

}
/* $PublicHoliday = array('01-01', '05-08', '07-14', '08-15', '11-11',
$easterDate->format('m-d'), $ascensionDate->format('m-d'), $pentecostDate->format('m-d'))

foreach ($PublicHoliday as $element)
{
if ($day==$element)
        {
            $this->context->addViolation($constraint->message);
        }
}
*/