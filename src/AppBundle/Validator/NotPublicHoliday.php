<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 02/09/2017
 * Time: 18:50
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotPublicHoliday extends Constraint

{
public $message = "La réservation est impossible ce jour";
}