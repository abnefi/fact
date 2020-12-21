<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SuperAdmin;
use ConfigBundle\Entity\ConfigAgence;
use ConfigBundle\Entity\ConfigRaisonRejet;
use ConfigBundle\Entity\ConfigSociete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Superadmin controller.
 *
 * @Route("/operations/liees/activations/desactivation/societes/par/superadmin")
 */
class SuperAdminController extends Controller
{
    /**
     * Espace du superAdmin pour gerer les différents comptes des sociétés.
     *
     * @Route("/gestions/societes/par/superadmin", name="index_gestion_societe")
     * @Method("GET")
     */
    public function GestionCompte(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $mesSocietes = $em->getRepository('ConfigBundle:ConfigSociete')->findBy([], ['updateAt' => 'DESC']);
        return $this->render('superadmin/index.html.twig',array('Societes'=>$mesSocietes));
    }


    /**
     * @Route("/recuperation/liste/des/societes/et/users/en/attente/activation/incomplet", options={"expose"=true}, name="societe_et_user_en_attente_activation_incomplete")
     */
    public function getSociete(Request $request)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $monId=$request->get('monId');

            if ($monId=="listeAttente")
            {
                $liste_societes = $em->getRepository("ConfigBundle:ConfigSociete")->findBy(['estActif'=>0,'estSupprimer'=>0], ['created' => 'DESC']);

            } elseif ($monId=="listeIncomplete")
            {
                $liste_users = $em->getRepository("UserBundle:FosUser")->findBy(['estActiver'=>0,'estVerifier'=>0,'estSupprimer'=>0], ['created' => 'DESC']);

                $listeUsersAmin=array();

                foreach ($liste_users as $user)
                {
                    if ($user->hasRole('ROLE_CLT_ADMIN'))
                    {
                        $listeUsersAmin[$user->getId()]=$user;
                    }
                }
              // dump($listeUsersAmin);die();
                $liste_societes = array();

                foreach ($listeUsersAmin as $user)
                {
                    if ($user->getAgence() ==null)
                    {
                        $liste_societes=[];
                    } else
                    {
                        if ($user->getAgence()->getSociete() == null)
                        {
                            $liste_societes=[];
                        } else
                        {
                            $users_soc = $user->getAgence()->getSociete();
                            $liste_societes[$users_soc->getId()]=$users_soc;
                        }
                    }
                }

            } elseif ($monId=="listeDejaActiver")
            {
                $liste_societes = $em->getRepository("ConfigBundle:ConfigSociete")->findBy(['estActif'=>1,'estSupprimer'=>0], ['created' => 'DESC']);

            }

            return $this->render('superadmin/liste.html.twig', array(
                'SocietesEnAttentes' => $liste_societes,
            ));
        }
    }


    /**
     * Creates a new superAdmin entity.
     *
     * @Route("/new", name="superadmin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $superAdmin = new Superadmin();
        $form = $this->createForm('AppBundle\Form\SuperAdminType', $superAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($superAdmin);
            $em->flush();

            return $this->redirectToRoute('superadmin_show', array('id' => $superAdmin->getId()));
        }

        return $this->render('superadmin/new.html.twig', array(
            'superAdmin' => $superAdmin,
            'form' => $form->createView(),
        ));
    }

    /**
     * show and displays a societe entity.
     *
     * @Route("/affichage/de/chaque/societe/par/admin/show/{id}", name="show_une_societe")
     * @Method("GET")
     */
    public function showAction(Request $request,ConfigSociete $configSociete)
    {

        if(!is_null($configSociete->getIfuFile()) || $configSociete->getIfuFile() !== '' ){
            $urlifu = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/uploads/societe/' . $configSociete->getIfuFile();
        }
        else{
            $urlifu = '';
        }

        if(!is_null($configSociete->getRegistreFile() || $configSociete->getRegistreFile() !== '') ){
            $urlregiste = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/uploads/societe/' . $configSociete->getRegistreFile();
        }
        else{
            $urlregiste = '';
        }

        $configAgences = $this->getDoctrine()->getRepository('ConfigBundle:ConfigAgence')->findBy(['estSupprimer'=>0,'societe'=>$configSociete]);

        return $this->render('superadmin/show.html.twig', array(
            'societe' => $configSociete,
            'urlIfu'=>$urlifu,
            'urlRegiste'=>$urlregiste,
            'configAgences'=>$configAgences
        ));
    }


    /**
     * Displays and activate a societe entity ifu or register of selling.
     *
     * @Route("/activer/societe/par/superadmin", name="activer_societe")
     * @Method({"GET", "POST"})
     */
    public function activerSociete(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $portServeur = $request->request->get('portServeur');
        $idSociete = $request->request->get('idSocieteCliquer');
        $societe = $em->getRepository('ConfigBundle:ConfigSociete')->findOneBy(array('id' => $idSociete, 'estSupprimer' => 0));
        $agence = $em->getRepository('ConfigBundle:ConfigAgence')->findOneBy(array('societe' => $societe, 'libelle' => 'Agence principal'), array('created' => 'DESC'));
        $ag = $em->getRepository('ConfigBundle:ConfigAgence')->findOneBy(array('portServeur' => $portServeur));

        if ($societe !== null){
            if ($agence !== null){
                if ($ag !== null){
                    $request->getSession()->getFlashBag()->add('avertir', 'Ce port serveur est déjà rattaché à une agence.');
                    return $this->redirectToRoute('index_gestion_societe');
                }else{
                    if ($societe->getEstActif() == false){
                        $societe->setEstActif(true);
                        $agence->setPortServeur($portServeur);
                        $societe->setUpdateBy($this->getUser()->getSlug());
                        $societe->setUpdateAt(new \DateTime());
                        $em->flush();
                        $request->getSession()->getFlashBag()->add('success', 'Activation réussie.');
                        return $this->redirectToRoute('index_gestion_societe');
                    }
                }
            }
         }else{
             $request->getSession()->getFlashBag()->add('success', 'La société n\'existe pas.');
             return $this->redirectToRoute('index_gestion_societe');
         }
//
    }

    /**
     * Displays and desactivate a societe entity ifu or register of selling.
     *
     * @Route("/{id}/désactiver/societe/par/superadmin", name="desactiver_societe")
     * @Method({"GET", "POST"})
     */
    public function desactiverSociete(Request $request, ConfigSociete $societe)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $agence = $em->getRepository('ConfigBundle:ConfigAgence')->findOneBy(array('societe' => $societe, 'libelle' => 'Agence principal'), array('created' => 'DESC'));
        if ($societe !== null){
            if ($agence !== null){
                if ($societe->getEstActif()){
                    $societe->setEstActif(false);
                    $agence->setPortServeur(null);
                    $societe->setUpdateBy($this->getUser()->getSlug());
                    $societe->setUpdateAt(new \DateTime());
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'Désactivation réussie.');
                    return $this->redirectToRoute('index_gestion_societe');
                }
            }
         }else{
             $request->getSession()->getFlashBag()->add('success', 'La société n\'existe pas.');
             return $this->redirectToRoute('index_gestion_societe');
         }
    }


    /**
     * show and displays a societe entity ifu or register of selling.
     *
     * @Route("/rejeter/societe/par/superadmin", name="rejeter_societe_par_admin")
     * @Method({"GET", "POST"})
     */
    public function rejeterSociete(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $idSociete=$request->request->get('idSocieteCliquer');
        $raisonRejet=$request->request->get('raisonrejet');

        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository('ConfigBundle:ConfigSociete')->find($idSociete);
        $configRejet = new ConfigRaisonRejet();

        if (!$societe->getEstSupprimer())
        {
            if (!$societe->getEstActif())
            {
                $configRejet->setLue(0);
                $configRejet->setRaison($raisonRejet);
                $configRejet->setSociete($societe);
                $configRejet->setCreated(new \DateTime());
                $configRejet->setCreatedBy($this->getUser()->getSlug());
                $em->persist($configRejet);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Rejet reussit avec succes');
                return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
            } else {
                $request->getSession()->getFlashBag()->add('avertir', ' Cette société est déja activée. Merci');
                return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
            }
        } else
        {
            $request->getSession()->getFlashBag()->add('fail', 'Désolé, cette société est supprimé.');
            return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
        }
    }


    /**
     * Deletes a superAdmin entity.
     *
     * @Route("/{id}", name="configSociete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigSociete $configSociete)
    {
        $form = $this->createDeleteForm($configSociete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configSociete);
            $em->flush();
        }

        return $this->redirectToRoute('superadmin_index');
    }

    /**
     * Creates a form to delete a superAdmin entity.
     *
     * @param SuperAdmin $superAdmin The superAdmin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigSociete $configSociete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configSociete_delete', array('id' => $configSociete->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Supprimer societe by setEstSupprimmer.
     *
     * @Route("/supprimmer/societe/par/admin/{id}", name="supprimmer_societe_par_admin")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ConfigSociete $configSociete, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();


        if ($configSociete->getEstSupprimer())
        {
            $configSociete->setEstSupprimer(false);
            $configSociete->setUpdateBy($this->getUser()->getSlug());
            $configSociete->setUpdateAt(new \DateTime());
            $request->getSession()->getFlashBag()->add('success', 'Annulation de Suppression réussie.');

        } else
        {
            $configSociete->setEstSupprimer(true);
            $configSociete->setUpdateBy($this->getUser()->getSlug());
            $configSociete->setUpdateAt(new \DateTime());
            $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        }

        $em->flush();
        return $this->redirectToRoute('index_gestion_societe');
    }


    /**
     * Désactivation Agence par admin .
     *
     * @Route("/desactivation/par/admin/de/agence/{id}", name="desactivation_par_admin_de_agence")
     * @Method({"GET", "POST"})
     */
    public function desactivationDagenceAdmin(ConfigAgence $configAgence, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $configAgence->setEstActif(false);
        $configAgence->setEtatDemande(false);
        $configAgence->setPortServeur(null);

        $configAgence->setUpdateBy($this->getUser()->getSlug());
        $configAgence->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Désactivation  réussie.');
        return $this->redirectToRoute('show_une_societe',array('id'=>$configAgence->getSociete()->getId()));

    }


    /**
     * Demande d'activation de d'agence
     *
     * @Route("activation/agence/par/admin", name="activer_agence_par_admin")
     * @Method({"GET", "POST"})
     */
    public function ActivationAgenceAdmin(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $idAgence=$request->request->get('idAgenceCliquer');
        $port=$request->request->get('portServeur');

        $configAgence = $em->getRepository('ConfigBundle:ConfigAgence')->find($idAgence);
        $societe = $configAgence->getSociete();

        $ExisteAgence = $em->getRepository('ConfigBundle:ConfigAgence')->findBy(['portServeur'=>$port]);

        if ($ExisteAgence != null) {
            $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Une Agence est deja associe à ce port.');
            return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
        } else
        {
            if($societe->getEstActif())
            {
                $AbonementSocAgence = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findOneBy(['societe'=>$societe,'estActif'=>1,'estSupprimer'=>0]);

                if ($AbonementSocAgence !== null)
                {
                    $limiteAgence = $AbonementSocAgence->getTypeAbonnement()->getLimiteAgence();
                    $NombreAgenceActif = count($em->getRepository('ConfigBundle:ConfigAgence')->findBy(['societe'=>$societe,'estActif'=>1]));

                    if ($NombreAgenceActif  < $limiteAgence)
                    {
                        if (!$configAgence->getEstSupprimer()) {
                            if ($configAgence->getEtatDemande()) {
                                $configAgence->setEtatDemande(false);
                                $configAgence->setEstActif(true);
                                $configAgence->setPortServeur($port);
                                $configAgence->setUpdateBy($this->getUser()->getSlug());
                                $configAgence->setUpdateAt(new \DateTime());
                                $em->flush();
                                $request->getSession()->getFlashBag()->add('success', 'Activation reussit avec succes');
                                return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
                            } else {
                                $request->getSession()->getFlashBag()->add('avertir', ' Aucune demande d\'activation n\'est liée à cette agence. Merci');
                                return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
                            }
                        } else
                        {
                            $request->getSession()->getFlashBag()->add('fail', 'Désolé, cette agence est supprimé.');
                            return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
                        }
                    } else
                    {
                        $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Vous avez atteint le nombre limite d\'agence pour cet abonnement');
                        return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
                    }

                } else
                {
                    $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Vous n\'avez aucun abonnement actif pour le moment');
                    return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
                }
            } else
            {
                $request->getSession()->getFlashBag()->add('avertir', 'Désolé, La société de cette agence n\'est pas encore ativer.');
                return $this->redirectToRoute('show_une_societe',array('id'=>$societe->getId()));
            }
        }
    }
}
