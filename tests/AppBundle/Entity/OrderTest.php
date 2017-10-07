<?php
namespace  Tests\Appbundle\Entity;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Type;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 25/09/2017
 * Time: 10:03
 */
class OrderTest extends TestCase
{
    /**
     * @dataProvider orderDatasProvider
     * @param $coeff
     * @param $reduce
     * @param $birthday
     * @param $expected
     */
    public function testTarif($coeff,$reduce,$birthday,$expected)
    {
        $order = new Order();
        $ticket = new Ticket();
        $type= new Type();
        $type->setCoeff($coeff);

        $ticket->setBirthdate(new DateTime($birthday));
        $ticket->setReduced($reduce);
        $order -> addTicket($ticket);
        $order->setType($type);
        $this->assertSame($expected,$order->getTarif());
    }

    public function orderDatasProvider(){
        // array(coeff, reduit, dateNaissance, valeurAttendu)
        return [
            [1,true,"1976-04-12",10],
            [1,false,"1940-04-12",12],
            [1,false,"2007-04-12",8],
            [1,false,"2015-04-12",0],
            [1,true,"2015-04-12",0],
            [1,false,"1976-04-12",16]
        ];
    }
}