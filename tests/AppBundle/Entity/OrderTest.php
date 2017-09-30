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
    public function testTarifNormalOrder()
    {
        $order = new Order();
        $ticket = new Ticket();
        $type= new Type();
        $type->setCoeff('1');

        $ticket->setBirthdate(new DateTime('1976-04-12'));

        $order -> addTicket($ticket);
        $order->setType($type);
        $this->assertSame(16,$order->getTarif());
    }

    public function testTarifEnfantOrder()
    {
        $order = new Order();
        $ticket = new Ticket();
        $type= new Type();
        $type->setCoeff('1');

        $ticket->setBirthdate(new DateTime('2007-04-12'));

        $order -> addTicket($ticket);
        $order->setType($type);
        $this->assertSame(8,$order->getTarif());
    }

    public function testTarifGratuitOrder()
    {
        $order = new Order();
        $ticket = new Ticket();
        $type= new Type();
        $type->setCoeff('1');

        $ticket->setBirthdate(new DateTime('2015-04-12'));

        $order -> addTicket($ticket);
        $order->setType($type);
        $this->assertSame(0,$order->getTarif());
    }

    public function testTarifSeniorOrder()
    {
        $order = new Order();
        $ticket = new Ticket();
        $type= new Type();
        $type->setCoeff('1');

        $ticket->setBirthdate(new DateTime('1940-04-12'));

        $order -> addTicket($ticket);
        $order->setType($type);
        $this->assertSame(12,$order->getTarif());
    }

    public function testTarifReduitOrder()
    {
        $order = new Order();
        $ticket = new Ticket();
        $type= new Type();
        $type->setCoeff('1');
        $ticket->setReduced(true);
        $ticket->setBirthdate(new DateTime('1976-04-12'));
        $order -> addTicket($ticket);
        $order->setType($type);
        $this->assertSame(10,$order->getTarif());
    }
}