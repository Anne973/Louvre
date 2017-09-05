<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 27/08/2017
 * Time: 15:33
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class NotTuesday extends Constraint
{
    public $message ="Le musée est fermé le mardi, veuillez choisir une autre date";
}