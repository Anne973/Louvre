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
use AppBundle\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderManager
{
    private $session;
    private $em;

    public function __construct(Session $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em=$em;

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
    public function ticket(){
        $order = $this->session->get('order');
        $order->setType($this->em->getRepository(Type::class)->find($order->getType()->getId()));
        return $order;
    }


}