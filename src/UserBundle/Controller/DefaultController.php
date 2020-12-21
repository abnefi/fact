<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * send mail
     *
     * @Route("/mail", name="mail")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        return $this->render('guest/parts/new_user_mail_templateNew.html.twig', array(
            'name' => 'Romuald',
        ));
    }

}
