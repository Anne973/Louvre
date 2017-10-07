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
use Twig\Environment;

class OrderManager
{
    private $session;
    private $em;
    private $mailer;
    private $twig;

    public function __construct(Session $session, EntityManagerInterface $em, \Swift_Mailer $mailer, Environment $twig)
    {
        $this->session = $session;
        $this->em=$em;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function stepOne(){
        $order = new Order();
        $this->session->set('order',$order);
        return $order;
    }

    /**
     * @param $order
     * @return bool
     */
    private function isValidForStep2(Order $order = null)
    {

        if (isset($order)){
            if (!empty($order->getDate()) && !empty($order->getType()) && !empty($order->getNumber()) && !empty($order->getAdresse()))
            {
            return true;
            }
        }
        return false;
    }


    public function sendConfirmMail(Order $order,$from)
    {
        $message = (new \Swift_Message('Votre réservation'))
            ->setFrom($from)
            ->setTo($order->getAdresse())
            ->setBody(
                $this->twig->render(
                    'Emails/e_ticket.html.twig',
                    array('order' => $order)
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    private function isValidForRecap(Order $order = null){
        $isValidStep1 = $this->isValidForStep2($order);

        if ($isValidStep1){
            if($order->getTickets()->count() === $order->getNumber()){
                return true;
            }
        }

        return false;
    }





    public function stepTwo(){

        $order = $this->session->get('order',null);

        if(!$this->isValidForStep2($order)){
            throw new \Exception();
        }


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

        if(!$this->isValidForRecap($order)){
            throw new \Exception();
        }
        $order->setType($this->em->getRepository(Type::class)->find($order->getType()->getId()));
        return $order;
    }


}