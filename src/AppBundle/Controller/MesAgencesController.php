<?php

namespace AppBundle\Controller;

use ConfigBundle\Entity\ConfigAgence;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Superadmin for mes agences controller.
 *
 * @Route("/operations/liste/des/agenes/en/attentes/de/activation/par/superadmin")
 */
class MesAgencesController extends Controller
{
    /**
     * Lists all configAgence for superadmin entities.
     *
     * @Route("/", name="configagence_index_for_super_admin")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();
        $em = $this->getDoctrine()->getManager();

        $configAgences = $em->getRepository('ConfigBundle:ConfigAgence')->findBy(['estSupprimer'=>0], ['updateAt' => 'DESC']);

        return $this->render('superadmin/agencesgestion/index.html.twig', array(
            'configAgences' => $configAgences,
        ));
    }



    /**
     * Finds and displays a configAgence entity.
     *
     * @Route("/{id}", name="configagence_show_for_super_admin")
     * @Method("GET")
     */
    public function showAction(Request $request,ConfigAgence $configAgence)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('superadmin/agencesgestion/show.html.twig', array(
            'configAgence' => $configAgence,
        ));
    }


    /**
     * Lists all configAgence en attente for superadmin entities.
     *
     * @Route("/",options={"expose"=true},name="configagence_en_attente_for_super_admin")
     */
    public function listeEnAttenteAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $configAgences = $em->getRepository('ConfigBundle:ConfigAgence')->findBy(['estSupprimer'=>0,'estActif'=>0,'etatDemande'=>1], ['updateAt' => 'DESC']);


        return $this->render('superadmin/agencesgestion/liste.html.twig', array(
            'configAgences' => $configAgences,
        ));
    }



    /**
     * Demande d'activation de d'agence
     *
     * @Route("activation/agence/par/admin", name="activer_agence_par_admin_for_super_admin")
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
        $societe=$configAgence->getSociete();

        $ExisteAgence = $em->getRepository('ConfigBundle:ConfigAgence')->findBy(['portServeur'=>$port]);

        if ($ExisteAgence != null) {
            $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Une Agence est deja associe à ce port.');
            return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
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
                                return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
                            } else {
                                $request->getSession()->getFlashBag()->add('avertir', ' Aucune demande d\'activation n\'est liée à cette agence. Merci');
                                return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
                            }
                        } else
                        {
                            $request->getSession()->getFlashBag()->add('fail', 'Désolé, cette agence est supprimé.');
                            return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
                        }
                    } else
                    {
                        $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Vous avez atteint le nombre limite d\'agence pour cet abonnement');
                        return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
                    }

                } else
                {
                    $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Vous n\'avez aucun abonnement actif pour le moment');
                    return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
                }
            } else
            {
                $request->getSession()->getFlashBag()->add('avertir', 'Désolé, La société de cette agence n\'est pas encore ativer.');
                return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$societe->getId()));
            }
        }
    }

    /**
     * Désactivation Agence par admin .
     *
     * @Route("/desactivation/par/admin/de/agence/{id}", name="desactivation_par_admin_de_agence_for_super_admin")
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
        return $this->redirectToRoute('configagence_index_for_super_admin',array('id'=>$configAgence->getSociete()->getId()));

    }


}
