<?php

namespace Arkon\Bundle\PhoneBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ArkonPhoneBookBundle:Default:index.html.twig', array('name' => $name));
    }
}
