<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 28/08/2017
 * Time: 10:17
 */

namespace AppBundle\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotSunday extends Constraint
{
    public $message ="Le musée est fermé le dimanche, veuillez choisir une autre date";
}