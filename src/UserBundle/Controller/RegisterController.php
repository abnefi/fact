<?php

namespace UserBundle\Controller;

use ConfigBundle\ConfigBundle;
use ConfigBundle\Entity\ConfigAbonnementSociete;
use ConfigBundle\Entity\ConfigSociete;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\FosUser;

use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisterController extends Controller
{

    /**
     * Creates a new user entity.
     *
     * @Route("/register/user", name="fos_user_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {

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
            $user->setRoles(['ROLE_CLT_ADMIN']);
            $user->setCreated(new \DateTime());
            $user->setUserPublicId(' ');
            $user->setEmailCanonical($data['email']);
            $user->setEnabled(1);
            $em->persist($user);
            $em->flush();

            // TODO: envoyer le mail de confirmation
            $id = $user->getId();
            $slug = $user->getSlug();
            $slug = sha1($slug);
            $url = $request->getSchemeAndHttpHost()
                . $this->container->get('router')->getContext()->getBaseUrl()
                . '/register/confirm/' . $id . '/' . $slug;
            $template = $this->render('guest/parts/new_user_mail_templateNew.html.twig', array(
                'name' => $user->getUsername(),
                'url' => $url,
            ));
            $this->get('app.mail')->sender(
                'Mail de confirmation',
                $user->getEmail(),
                $template,
                ['marnel.gnacadja@ogi-informatique.com']
            );

            //http://127.0.0.1/facturation/web/app_dev.php/register/confirm/17/ab10ac297528103f09215e58c229b7a338edcec6


            // TODO: On le redirige vers notre super page
            $error = null;
            return $this->render('guest/parts/confirmRegister.html.twig', array(
                'error' => $error,
            ));
//            return $this->redirectToRoute('mail_confirm');
        }
        END:
        return $this->render('guest/parts/register.html.twig', array(
            'userform' => $form->createView(),
        ));
    }


    /**
     * send mail
     *
     * @Route("/send/mail", name="mail_sender")
     * @Method({"GET", "POST"})
     */
    public function mailSender(Request $request){

        $req = $request->request;
        $mail = $req->get('confirmMail');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('UserBundle:FosUser')->findOneBy(['email' => $mail]);

        if ( $user !== null ){
            $id = $user->getId();
            $slug = $user->getSlug();
            $slug = sha1($slug);
            $url = $request->getSchemeAndHttpHost()
                . $this->container->get('router')->getContext()->getBaseUrl()
                . '/register/confirm/' . $id . '/' . $slug;

            $this->get('app.mail')->sender(
                'Mail de confirmation',
                $user->getEmail(),
                $url,
                ['marnel.gnacadja@ogi-informatique.com']
            );

            $error = null;
            $request->getSession()->getFlashBag()->add('success', 'E-mail renvoyé avec succès');
            return $this->render('guest/parts/confirmRegister.html.twig', array(
                'error' => $error,
            ));
        }else{
            $error = null;
            $request->getSession()->getFlashBag()->add('echec', 'l\'adresse E-mail renseigner n\'est rataché à aucun compte');
            return $this->render('guest/parts/confirmRegister.html.twig', array(
                'error' => $error,
            ));
        }
        $error = null;
        $request->getSession()->getFlashBag()->add('echec', 'Désolé, adresse mail incorrecte');
        return $this->render('guest/parts/confirmRegister.html.twig', array(
            'error' => $error,
        ));
    }


    /**
     * comfirm link by mail.
     *
     * @Route("/register/confirm/{id}/{slug}", name="confirm_link")
     * @Method({"GET", "POST"})
     */
    public function confirmLinkAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        try{
            $req = $request->attributes;
            $user = $em->getRepository('UserBundle:FosUser')->find($req->get('id'));
            if ($user != null){
                $user->setEstVerifier(true);
                $em->persist($user);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Email confirmé avec succès. Veuillez vous connecté');
                return $this->redirectToRoute('fos_user_security_login');
            }else{
                $error = array('Désolé ! Le lien de confirmation est incorrect.
                                Si cela persiste, veuillez contacter l\'administrateur ou faire une demande de renvoi d\'e-mail.');
            }
        }catch (\Exception $exception){
            $error = array('Désolé ! Le lien de confirmation est incorrect. 
                             Si cela persiste, veuillez contacter l\'administrateur ou faire une demande de renvoi d\'e-mail.');
        }
        return $this->render('guest/parts/confirmRegister.html.twig', array(
            'error' => $error,
        ));
    }


    /**
     * redirect contrôleur.
     *
     * @Route("/redirect/user", name="redirect_user")
     * @Method({"GET", "POST"})
     * @param Request $request
     */
    public function redirectUserAction(Request $request)
    {
        /** @var FosUser $user */
        if (!$user = $this->getUser()) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();

        if ( $user !== null ){
            $agence = $user->getAgence();

        }
        $societe = $agence ? $agence->getSociete() : null;
        $portserveur = $agence ? $agence->getPortServeur() : null;

        if ($user->hasRole('ROLE_CLT_ADMIN')){
            if ($user->getEstVerifier()){
                if ($agence){
                    if ($user->getEstActiver()){
                        $request->getSession()->getFlashBag()->add('success', 'Bienvenue dans IGO-Facturation');
                        return $this->redirectToRoute('dashboard_index');
                    }else{
                        $raisonRejet = $em->getRepository('ConfigBundle:ConfigRaisonRejet')
                            ->findBy(array('societe' => $societe->getId(), 'estSupprimer' => 0), ['updateAt' => 'DESC']);
                        $count = 0;
                        for ($i = 0, $iMax = count($raisonRejet); $i < $iMax; $i++){
                            $raison[] = $raisonRejet[$i]->getRaison();
                            $count++;
                            $request->getSession()->getFlashBag()->add('raison', $raison[$i]);
                        }
                        return $this->redirectToRoute('verification_activation', array(
                            'cc' => $count,
                        ));
                    }
                }else{
                    return $this->redirectToRoute(  'additional_new');
                }
            }else{
                $this->get('security.token_storage')->setToken(null);
                $error = null;
                return $this->render('guest/parts/confirmRegister.html.twig', array(
                    'error' => $error,
                ));
            }

        }elseif ($user->hasRole('ROLE_FNS_ADMIN') || $user->hasRole('ROLE_ADMIN')){

            $request->getSession()->getFlashBag()->add('success', 'Bienvenue dans IGO-Facturation');
            return $this->redirectToRoute('dashboard_admin_index');

        }else{

            if ($agence !== null && $portserveur !== null){
                if ($em->getRepository(ConfigAbonnementSociete::class)->hasActifAbonnement($societe)){
                    if ($user->isEnabled()){
                        $request->getSession()->getFlashBag()->add('success', 'Bienvenue dans IGO-Facturation');
                        return $this->redirectToRoute('dashboard_index');
                    }else{
                        $this->get('security.token_storage')->setToken(null);
                        $request->getSession()->getFlashBag()->add('sms', 'Votre compte a été désactivé, veuillez contacter votre administrateur.');
                        return $this->redirectToRoute('fos_user_security_login');
                    }
                }else{
                    $request->getSession()->getFlashBag()->add('sms', 'Aucun abonnement en cours pour votre société, veuillez souscrire à un produit.');
                    $this->get('security.token_storage')->setToken(null);
                    return $this->redirectToRoute('fos_user_security_login');
                }
            }else{
                $this->get('security.token_storage')->setToken(null);
                $request->getSession()->getFlashBag()->add('echec', 'Echec connexion, veuillez partienter pendant l\'activation de votre agence');
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
    }


    /**
     * Creates a new user entity.
     *
     * @Route("/register/user", name="mail_confirm")
     * @Method({"GET", "POST"})
     */
    public function mailconfirmAction(Request $request)
    {
        $user = new FosUser();
        $form = $this->createForm('UserBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);


        return $this->render('guest/parts/confirmRegister.html.twig');
    }

}
