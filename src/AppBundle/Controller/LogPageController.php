<?php


namespace AppBundle\Controller;

use ConfigBundle\Entity\ConfigSociete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Entity\FosUser;

/**
 * LogePage controller.
 * @Route("logpage")
 */
class LogPageController extends Controller
{

    /**
     * @Route   ("/log/page/index", name="logpageindex")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_FNS_ADMIN']))
        {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $user = $this->getUser();
        $agence = $user->getAgence();
        if (null === $agence) {
            throw new NotFoundHttpException("Cet utilisateur n'est lié à aucune société.");
        }
        $session = new Session();
        $session->set('id_societe', $agence->getSociete()->getId());
        $session->set('type_activite', $agence->getSociete()->getTypeActivite()->getCode());

        return $this->render('logpage/index.html.twig', []);

    }

}
