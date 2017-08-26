<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Order;


use AppBundle\Entity\Ticket;
use AppBundle\Entity\Type;
use AppBundle\Form\OrderStepOneType;
use AppBundle\Form\OrderStepTwoType;


use AppBundle\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/selection_step_one", name="eticket_selection_step_one")
     */
    public function selectStepOneAction(Request $request, OrderManager $orderManager)
    {

        $order=$orderManager->stepOne();



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
    public function selectStepTwoAction(Request $request, OrderManager $orderManager)
    {
            $order=$orderManager->stepTwo();



            $form = $this->createForm(OrderStepTwoType::class, $order);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {



                return $this->redirectToRoute('eticket_ticket');
            }

            return $this->render(':Order:selectStepTwo.html.twig', array(
                'form' => $form->createView(),
                'order'=>$order
            ));
        }



        /**
         * @return \Symfony\Component\HttpFoundation\Response
         * @Route("/ticket", name="eticket_ticket")
         */
        public
        function ticketAction(Request $request)
        {

            return $this->render(':Order:ticket.html.twig', array(
                'order'=>$request->getSession()->get('order')
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