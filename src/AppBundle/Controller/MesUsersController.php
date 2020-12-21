<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\FosUser;



/**
 * Superadmin for mes mes  simples users controller.
 *
 * @Route("/liste/de/mes/simple/users/par/superadmin")
 */
class MesUsersController extends Controller
{
    /**
     * Lists all Fosuser for superAdmin entities.
     *
     * @Route("/", name="liste_of_simple_users_index_for_super_admin")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN', 'ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        }

            $em = $this->getDoctrine()->getManager();

            $listeUsers = $em->getRepository('UserBundle:FosUser')->findAll();
            return $this->render('superadmin/usersgestion/index.html.twig', ['users' => $listeUsers]);
        }


    /**
     * show a Fosuser for superAdmin entity.
     *
     * @Route("/{id}", name="fosuser_show_for_super_admin")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, FosUser $user)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN', 'ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        }

        return $this->render('superadmin/usersgestion/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Désactivation des utilisateurs par fns_admin .
     *
     * @Route("/desactivation/par/fns/admin/de/user/{id}", name="desactivation_par_admin_de_user")
     * @Method({"GET", "POST"})
     */
    public function desactivationDeUserParAdmin(FosUser $fosUser, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $fosUser->setEnabled(false);

        $fosUser->setUpdateBy($this->getUser()->getSlug());
        $fosUser->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Désactivation  réussie.');
        return $this->redirectToRoute('liste_of_simple_users_index_for_super_admin');

    }

    /**
     * Désactivation des utilisateurs par fns_admin .
     *
     * @Route("/activation/par/fns/admin/de/user/{id}", name="activation_par_admin_de_user")
     * @Method({"GET", "POST"})
     */
    public function activationDeUserParAdmin(FosUser $fosUser, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $fosUser->setEnabled(true);

        $fosUser->setUpdateBy($this->getUser()->getSlug());
        $fosUser->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Activation  réussie.');
        return $this->redirectToRoute('liste_of_simple_users_index_for_super_admin');

    }

}
