<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 28/08/2017
 * Time: 10:33
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotClosingDay extends Constraint

{

    public $message ="Le musée est fermé les 1er mai, 1er novembre et 25 décembre, veuillez choisir une autre date";

}