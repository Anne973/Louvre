<?php
namespace EticketBundle\Controller;


use EticketBundle\Entity\Order;
use EticketBundle\Entity\Ticket;

use EticketBundle\EticketBundle;
use EticketBundle\Form\OrderType;
use EticketBundle\Form\TicketType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;





class OrderController extends Controller
{
    public function selectAction(Request $request)
    {
        //on crée un objet Order
        $order = new Order();


        // On crée le formulaire
        $form= $this->get('form.factory')->create(OrderType::class, $order);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();


            $request->getSession()->getFlashBag()->add('notice', 'Billet bien enregistré.');

           return $this->redirectToRoute('eticket_ticket', array('id'=>$order->getId()));
        }


                // On passe la méthode createView() du formulaire à la vue

                return $this->render('EticketBundle:Order:select.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function ticketAction(Order $order)
    {
       
        return $this->render ('EticketBundle:Order:ticket.html.twig', array(
            'order'=>$order
        ));
    }
}






/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 12/08/2017
 * Time: 12:25
 */