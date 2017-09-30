<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="eticket_redirectpage")
     */
     public function redirectAction()
    {
        return $this->redirectToRoute('eticket_homepage');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/", name="eticket_homepage")
     */
    public function indexAction()
    {
        return $this->render(':Home:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/mentions_legales", name="eticket_legales")
     */
    public function legalesAction()
    {
        return $this->render(':Home:legales.html.twig');
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/contact", name="eticket_contact")
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        $contact=new Contact;
        $form =$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $message = (new Swift_Message('Contact from Eticket louvre'))
                ->setFrom($contact->getEmail())
                ->setTo($this->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/registration.html.twig',
                        array('contact' => $contact)
                    ),
                    'text/html'
                )

            ;

            $mailer->send($message);


            return $this->render(':Home:confirmation.html.twig');
        }
        return $this-> render(':Home:contact.html.twig', array(
            'form' => $form->createView()));
    }




}
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 12/08/2017
 * Time: 12:44
 */