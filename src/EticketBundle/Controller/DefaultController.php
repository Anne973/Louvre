<?php

namespace EticketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EticketBundle:Default:index.html.twig');
    }
}
