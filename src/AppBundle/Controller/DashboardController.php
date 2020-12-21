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
 * Dashboard controller.
 *
 * @Route("")
 */
class DashboardController extends Controller
{
    /**
     * @Route   ("/dashboard", name="dashboard_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $request->getSession()->set('user_id', $this->getUser()->getId());
        if ($this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']))
        {
            return $this->redirectToRoute('dashboard_admin_index');

        }

        $user = $this->getUser();
        $agence = $user->getAgence();
        if (null === $agence) {
            throw new NotFoundHttpException("Cet utilisateur n'est lié à aucune société.");
        }

        $roles = $this->getUser()->getRoles();
        $roleOk=false;

        foreach ($roles as $role)
        {
            if ($role == 'ROLE_FNS_ADMIN' || $role == 'ROLE_ADMIN')
            {
                $roleOk=true;
            }
        }

        $session = new Session();
        $session->set('roleOk', $roleOk);
        $session->set('id_societe', $agence->getSociete()->getId());
        $session->set('type_activite', $agence->getSociete()->getTypeActivite()->getCode());

        return $this->render('dashboard/index.html.twig', []);

//
    }
    /**
     * @Route   ("/dashboard/Admin", name="dashboard_admin_index")
     * @Method("GET")
     */
    public function indexAdminDashAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);

        $request->getSession()->set('user_id', $this->getUser()->getId());

        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }


        $user = $this->getUser();
        $agence = $user->getAgence();
        if (null === $agence) {
            throw new NotFoundHttpException("Cet utilisateur n'est lié à aucune société.");
        }
        $roles = $this->getUser()->getRoles();
        $roleOk=false;

        foreach ($roles as $role)
        {
            if ($role == 'ROLE_FNS_ADMIN' || $role == 'ROLE_ADMIN')
            {
                $roleOk=true;
            }
        }

        $session = new Session();
        $session->set('roleOk', $roleOk);
        $session->set('id_societe', $agence->getSociete()->getId());
        $session->set('type_activite', $agence->getSociete()->getTypeActivite()->getCode());

        $em = $this->getDoctrine()->getManager();

        $totalUser =count( $em->getRepository("UserBundle:FosUser")->findAll());
        $totalUserActif = count($em->getRepository("UserBundle:FosUser")->findBy(['estActiver'=>1,'estVerifier'=>1,'estSupprimer'=>0]));
        $totalSocieteActive  = count($em->getRepository("ConfigBundle:ConfigSociete")->findBy(['estActif'=>1,'estSupprimer'=>0]));
        $totalSociete = count($em->getRepository("ConfigBundle:ConfigSociete")->findAll());



        return $this->render('dashboard/indexadmin.html.twig', [
            'users'=>$totalUser,
            'userActif'=>$totalUserActif,
            'societes'=>$totalSociete,
            'societesActives' =>$totalSocieteActive

        ]);
    }

    /**
     * @Route   ("/menu", name="menu")
     * @Method("GET")
     */
    public function menuAction(Request $request)
    {
        $user = $this->getUser();
//        dump($user);die();
        $agence = $user->getAgence();
        if (null === $agence) {
            throw new NotFoundHttpException("Cet utilisateur n'est lié à aucune société.");
        }
        $societe = $agence->getSociete();
        return $this->render('blocks/menu.html.twig', ['societe' => $societe]);
    }
}
