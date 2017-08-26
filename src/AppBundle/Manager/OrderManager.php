<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 26/08/2017
 * Time: 09:45
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderManager
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;


    }

    public function stepOne(){
        $order = new Order();
        $this->session->set('order',$order);
        return $order;
    }

    public function stepTwo(){

        $order = $this->session->get('order');


        for ($i =0; $i < $order->getNumber(); $i++) {
            if(count($order->getTickets())< $order->getNumber()) {
                $order->addTicket(new Ticket());

            }
            if(count($order->getTickets())> $order->getNumber()){
                $order->removeTicket($order->getTickets()->last());
            }
        }
        return $order;
    }
}