<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 20/03/2020
 * Time: 17:36
 */

namespace UserBundle\Controller;

use ConfigBundle\Entity\ConfigAbonnementSociete;
use ContainerXogGHg5\getSecurity_Logout_Listener_Default_MainService;
use \Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\FosUser;

/**
 * Fosuser controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all Fosuser entities.
     *
     * @Route("/", name="fosuser_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_CLT_ADMIN'], null,
            'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        //access user manager services
        //$userManager = $this->get('fos_user.user_manager');
        //$users = $userManager->findUsers();
        $em = $this->getDoctrine()->getManager();

        $SocieteUser=$this->getUser()->getAgence()->getSociete();
        $listeUsers = $em->getRepository('UserBundle:FosUser')->listeUsers($SocieteUser);
        $user = new FosUser();
        return $this->render('user/index.html.twig', ['users' => $listeUsers, 'user' => $user]);
    }

    /**
     * show a Fosuser entity.
     *
     * @Route("/{id}", name="fosuser_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, FosUser $user)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_CLT_ADMIN'], null,
            'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * edit a Fosuser entity.
     *
     * @Route("/{id}/edit", name="fosuser_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FosUser $user)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_CLT_ADMIN'], null,
            'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $roles = $this->getUser()->getRoles();
        $_userRoles = $user->getRoles();
        $roleOk=false;

        $OkRoleCltAdmin=false;

        foreach ($roles as $role)
        {
            if ($role == 'ROLE_FNS_ADMIN' || $role == 'ROLE_ADMIN')
            {
                $roleOk=true;
            }

            if ($role == 'ROLE_CLT_ADMIN')
            {
                $OkRoleCltAdmin=true;
            }
        }

        foreach ($_userRoles as $role)
        {
            if ($role == 'ROLE_CLT_ADMIN')
            {
                $OkRoleCltAdmin=true;
            }
        }

        $editForm = $this->createForm('UserBundle\Form\EditUserType', $user, ['role'=>$roleOk]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $userManager = $this->get('fos_user.user_manager');

            $user->setUpdateBy($this->getUser()->getSlug());
            $user->setUpdateAt(new \DateTime());

            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('success', "Modification de l'utilisateur ".$user->getUsername()." effectuée avec succès");
            return $this->redirectToRoute('fosuser_index');
        }

        if ($OkRoleCltAdmin)
        {
            return $this->render('user/editClt_Admin.html.twig', array(
                'form' => $editForm->createView(),
                'user' => $user,
            ));
        } else
        {
            return $this->render('user/edit.html.twig', array(
                'form' => $editForm->createView(),
                'user' => $user,
            ));
        }
    }


    /**
     * Supprimer user by setEstSupprimmer.
     *
     * @Route("/supprimmer/user/{id}", name="supprimmer_user")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(FosUser $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($user->getEstSupprimer())
        {
            $user->setEstSupprimer(false);
        } else
        {
            $user->setEstSupprimer(true);
        }

        $user->setUpdateBy($this->getUser()->getSlug());
        $user->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('fosuser_index');
    }


    /**
     * vérifier si un compte utilisateur est déjà ectivé ou non.
     *
     * @Route("/activate/verification", name="verification_activation")
     * @Method({"GET", "POST"})
     */
    public function CompteActivate(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $agence = $user ? $user->getAgence(): null;
        $agenceId =$agence ? $agence->getId(): null;

        $soc = $this->getUser()->getAgence()->getSociete();
        $etatEssaie = $soc->getDejaEssayer();
        $configAbonnementSociete = new Configabonnementsociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType', $configAbonnementSociete, ['etatEssaie'=>$etatEssaie]);
        $count = $request->query->get('cc');

        $form->handleRequest($request);

        $configAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnement')->findBy(['estActif' => true, 'estSupprimer' => false]);

        return $this->render('guest/parts/verifierActivation.html.twig', array(
            'configAgence' => $agence,
            'id' => $agenceId,
            'configAbonnements' => $configAbonnements,
            'form' => $form->createView(),
            'count' => $count
        ));

    }
}