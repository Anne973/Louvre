<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="eticket_homepage")
     */
    public function indexAction()
    {
        return $this->render(':Home:index.html.twig');
    }
}
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 12/08/2017
 * Time: 12:44
 */