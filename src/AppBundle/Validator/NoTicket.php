<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 29/08/2017
 * Time: 12:37
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class NoTicket extends Constraint
    {
    public $message="Il n'y a plus de tickets disponibles ce jour, veuillez choisir une autre date";

    public function validatedBy()
    {
        return 'eticket_noticket';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}