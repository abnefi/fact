<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\FosUser;

/**
 * SuperadminForUserAdmin controller.
 *
 * @Route("/gestions/superadmin")
 */
class UsersAdminController extends Controller
{
    /**
     * Espace du superAdmin pour gerer les différents comptes des Amin.
     *
     * @Route("/liste/admin", name="index_liste_users")
     * @Method("GET")
     */
    public function UsersAdminCompte(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $listeUsers = $em->getRepository('UserBundle:FosUser')->findAll();
        $listeUsersAmin=array();

        foreach ($listeUsers as $user)
        {
            if ($user->hasRole('ROLE_CLT_ADMIN'))
            {
                $listeUsersAmin[$user->getId()]=$user;
            }
        }

        return $this->render('superadmin/indexAdmins.html.twig', ['users' => $listeUsersAmin]);
    }

    /**
     * show a Fosuser entity.
     *
     * @Route("/affichage/admin/par/super/admin/{id}", name="admin_user_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(FosUser $user)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_FNS_ADMIN'], null,
            'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

            return $this->render('superadmin/adminshow.html.twig', array(
                'user' => $user,
            ));

    }


    /**
     * Supprimer user by setEstSupprimmer.
     *
     * @Route("/supprimmer/admin/user/{id}", name="supprimmer_admin")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(FosUser $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($user->getEstSupprimer()) {
            $user->setEstSupprimer(false);
            $user->setUpdateBy($this->getUser()->getSlug());
            $user->setUpdateAt(new \DateTime());
        } else {
            $user->setEstSupprimer(true);
            $user->setUpdateBy($this->getUser()->getSlug());
            $user->setUpdateAt(new \DateTime());
        }


        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('index_liste_users');
    }


    /**
     * Displays a form to edit an existing superAdmin entity.
     *
     * @Route("/{id}/gsqf6234/a5374d23m8642", name="activer_admin")
     * @Method({"GET", "POST"})
     */
    public function activerAdmin(Request $request, FosUser $fosUser)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        if (!$fosUser->getEstSupprimer()) {
            if ($fosUser->getEstVerifier()) {
                if ($fosUser->getEstActiver()) {
                    $fosUser->setEstActiver(false);
                    $fosUser->setUpdateBy($this->getUser()->getSlug());
                    $fosUser->setUpdateAt(new \DateTime());
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('avertir', 'Désactivation réussie.');
                    return $this->redirectToRoute('index_liste_users');
                } else {
                    $fosUser->setEstActiver(true);
                    $fosUser->setUpdateBy($this->getUser()->getSlug());
                    $fosUser->setUpdateAt(new \DateTime());
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'Activation réussie.');
                    return $this->redirectToRoute('index_liste_users');
                }
            } else {
                $request->getSession()->getFlashBag()->add('success', 'Désolé, il n\'est pas encore vérifer.');
                return $this->redirectToRoute('index_liste_users');
            }
        } else {
            $request->getSession()->getFlashBag()->add('success', 'Désolé, ce utilisateur est supprimé.');
            return $this->redirectToRoute('index_liste_users');
        }

        return $this->redirectToRoute('index_gestion_societe');
    }

    /**
     * @Route("/recuperer/liste/superadmin", options={"expose"=true}, name="user_activation_verifier")
     */
    public function getUsers(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();
            $monId = $request->get('monId');
            $listeUsersAmin=array();
            $listeUsersAmin = null;

            if ($monId == "userVerifier") {
                $liste_users = $em->getRepository("UserBundle:FosUser")->findBy(['estActiver' => 0, 'estVerifier' => 1, 'estSupprimer' => 0], ['created' => 'DESC']);

                foreach ($liste_users as $user)
                {
                    if ($user->hasRole('ROLE_CLT_ADMIN'))
                    {
                        $listeUsersAmin[$user->getId()]=$user;
                    }
                }

            } elseif ($monId == "userAutoriser") {
                $liste_users = $em->getRepository("UserBundle:FosUser")->findBy(['estActiver' => 1, 'estVerifier' => 1, 'estSupprimer' => 0], ['created' => 'DESC']);

                foreach ($liste_users as $user)
                {
                    if ($user->hasRole('ROLE_CLT_ADMIN'))
                    {
                        $listeUsersAmin[$user->getId()]=$user;
                    }
                }

            }

            return $this->render('superadmin/uliste.html.twig', array(
                'users' => $listeUsersAmin,
            ));
        }
    }



    /**
     * Creates a new user entity.
     *
     * @Route("/register/new/admin/user", name="new_admin_user_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $data = $request->get('app_user_registration');
        $user = new FosUser();
        $form = $this->createForm('UserBundle\Form\RegistrationType2', $user);

        $form->handleRequest($request);
        $passwordEncoder = $this->get('security.password_encoder');

        $response = $request->request->get('app_user_registration');
        $email = $response['email'];
        $username = $response['username'];

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $passwordEncoder->encodePassword($user,$user->getPlainPassword());

            $oldUsername = $em->getRepository(FosUser::class)->findOneBy(['username' => $username]);
            if ($oldUsername != null) {
                $error = new FormError('Le nom d\'utilisateur existe déjà');
                $form->addError($error);
                goto END;
            }
            $oldEmail = $em->getRepository('UserBundle:FosUser')->findOneBy(['email' => $email]);
            if ($oldEmail != null) {
                $error = new FormError('L\'email existe déjà');
                $form->addError($error);
                goto END;
            }

            $user->setPassword($password);
            $user->setCreated(new \DateTime());
            $user->setUserPublicId(' ');
            $user->setEmailCanonical($data['email']);
            $user->setEnabled(1);

            //TODO: on lie la société et l'agence d'OGI à l'administreur
            $agence = $em->getRepository('ConfigBundle:ConfigAgence')->findOneBy(array('code' => 'AG01'));
            $user->setAgence($agence);

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Enregistrement réussie.');
            return $this->redirectToRoute('index_liste_users');
        }
        END:
        return $this->render('superadmin/registerNewAdmin.html.twig', array(
            'form' => $form->createView(),
        ));
    }



}
