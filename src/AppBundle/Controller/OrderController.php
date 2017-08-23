<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Order;


use AppBundle\Entity\Ticket;
use AppBundle\Entity\Type;
use AppBundle\Form\OrderStepOneType;
use AppBundle\Form\OrderStepTwoType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/selection_step_one", name="eticket_selection_step_one")
     */
    public function selectStepOneAction(Request $request)
    {
        //on crée un objet Order
        $order = new Order();
        $type=new Type();
        $session = $request->getSession()->set('order',$order);



        // On crée le formulaire
        $form= $this->get('form.factory')->create(OrderStepOneType::class, $order);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

           return $this->redirectToRoute('eticket_selection_step_two');

        }


                // On passe la méthode createView() du formulaire à la vue

                return $this->render(':Order:selectStepOne.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/selection_step_two", name="eticket_selection_step_two")
     */
    public function selectStepTwoAction(Request $request)
    {
        $session = $request->getSession();
        $order = $session->get('order');
        $number = $session->get('order')->getNumber();
        for ($i =0; $i < $number; $i++) {
            $order->addTicket(new Ticket());


            $form = $this->get('form.factory')->create(OrderStepTwoType::class, $order);
            $form->handleRequest($request);
            // On passe la méthode createView() du formulaire à la vue

            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                return $this->redirectToRoute('eticket_ticket', array('id' => $order->getId()));
            }
            var_dump($form->getData());
            return $this->render(':Order:selectStepTwo.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }


        /**
         * @return \Symfony\Component\HttpFoundation\Response
         * @Route("/ticket/{id}", name="eticket_ticket")
         */
        public
        function ticketAction(Order $order)
        {

            return $this->render(':Order:ticket.html.twig', array(
                'order' => $order
            ));
        }

        /**
         * @return \Symfony\Component\HttpFoundation\Response
         * @Route("/checkout", name="eticket_checkout")
         */
        /* public  function checkoutAction()
         {
             \Stripe\Stripe::setApiKey("sk_test_YHG7jl1vcgMHQGc1jTtoAql1");

             $token = $_POST['stripeToken'];
             try {

             $charge = \Stripe\Charge::create(array(
                 "amount" => 1000,
                 "currency" => "eur",
                 "description" => "Paiement Stripe - Louvre",
                 "source" => $token,
             ));
             return $this ->redirectToRoute('eticket_checkout');
             }
             catch(\Stripe\Error\Card $e){
                 return $this ->redirectToRoute('eticket_ticket', array('id'=>$order->getId()));
             }
         }*/

    }






/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 12/08/2017
 * Time: 12:25
 */