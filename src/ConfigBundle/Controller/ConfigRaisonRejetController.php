<?php

namespace ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;

class ConfigRaisonRejetController extends Controller
{
    /**
     * @Route("/sendRaison")
     */
    public function sendRaisonAction(Request $request)
    {

        return $this->render('ConfigBundle:ConfigRaisonRejet:send_raison.html.twig', array(
            // ...
        ));
    }

}
