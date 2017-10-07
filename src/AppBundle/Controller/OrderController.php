<?php

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Entity\Order;


use AppBundle\Entity\Ticket;
use AppBundle\Entity\Type;
use AppBundle\Form\OrderStepOneType;
use AppBundle\Form\OrderStepTwoType;


use AppBundle\Manager\OrderManager;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/selection_step_one", name="eticket_selection_step_one")
     */
    public function selectStepOneAction(Request $request, OrderManager $orderManager)
    {

        $order = $orderManager->stepOne();


        // On crée le formulaire
        $form = $this->createForm(OrderStepOneType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            return $this->redirectToRoute('eticket_selection_step_two');

        }


        // On passe la méthode createView() du formulaire à la vue

        return $this->render(':Order:selectStepOne.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/selection_step_two", name="eticket_selection_step_two")
     */
    public function selectStepTwoAction(Request $request, OrderManager $orderManager)
    {
        try{
            $order = $orderManager->stepTwo();
        }
        catch(\Exception $e){
            //set flash error

           $this->get('session')->getFlashBag()->add('info', $this->get('translator')->trans('accès impossible'));

            //redirection page d'accueil
            return $this->redirectToRoute('eticket_homepage');
        }


        $form = $this->createForm(OrderStepTwoType::class, $order);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            return $this->redirectToRoute('eticket_ticket');
        }

        return $this->render(':Order:selectStepTwo.html.twig', array(
            'form' => $form->createView(),
            'order' => $order
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/ticket", name="eticket_ticket")
     */
    public function ticketAction(Request $request, OrderManager $orderManager)
    {
        try{
        $order = $orderManager->ticket();
        }

        catch(\Exception $e){
            //set flash error

            $this->get('session')->getFlashBag()->add('info','accès impossible');

            //redirection page d'accueil
            return $this->redirectToRoute('eticket_homepage');
        }
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_private_key'));

            $token = $_POST['stripeToken'];
            try {

                $charge = \Stripe\Charge::create([
                    "amount" => ($order->getTarif()) * 100,
                    "currency" => "eur",
                    "description" => $order->getNumber() . " entrée(s) - " . $order->getDate()->format('m-d-Y'),
                    "receipt_email" => $order->getAdresse(),
                    "source" => $token,
                ]);
                $order->setStripe($charge->id);

                $em->persist($order);
                $em->flush();
                $orderManager->sendConfirmMail($order,$this->getParameter('mailer_user'));

                $this->get('session')->clear();

                return $this->redirectToRoute('eticket_checkout', array('stripe' => $order->getStripe()));
            } catch (\Stripe\Error\Card $e) {
                return $this->redirectToRoute('eticket_ticket');
            }

        }

        return $this->render(':Order:ticket.html.twig', array(
            'order' => $request->getSession()->get('order')
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/checkout/{stripe}", name="eticket_checkout")
     */
    public function checkoutAction(Order $order)
    {
         return $this->render(':Order:checkout.html.twig', array('order' => $order));

    }


}






/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 12/08/2017
 * Time: 12:25
 */