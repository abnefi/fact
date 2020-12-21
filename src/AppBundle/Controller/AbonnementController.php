<?php

namespace AppBundle\Controller;

use ConfigBundle\Entity\ConfigAbonnement;
use ConfigBundle\Entity\ConfigAbonnementSociete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Configabonnement controller.
 *
 * @Route("configabonnement")
 */
class AbonnementController extends Controller
{
    /**
     * Lists all configAbonnement entities.
     *
     * @Route("/", name="configabonnement_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN', 'ROLE_FNS_ADMIN', 'ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $configAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnement')->findAll();

        return $this->render('superadmin/configabonnement/index.html.twig', array(
            'Abonnements' => $configAbonnements,
        ));
    }


    /**
     * Lists all configAbonnement par societe.
     *
     * @Route("/index/liste/abonnement/par/societe", name="index_liste_abonnement_par_societe")
     * @Method("GET")
     */
    public function indexAbonnementSocieteAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $configAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findBy([], ['createdAt' => 'DESC']);

        return $this->render('superadmin/configabonnement/listeSouscription.html.twig', array(
            'Abonnements' => $configAbonnements,
        ));
    }


    /**
     * Creates a new configAbonnement entity.
     *
     * @Route("/new", name="configabonnement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN', 'ROLE_FNS_ADMIN', 'ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $configAbonnement = new Configabonnement();
        $form = $this->createForm('ConfigBundle\Form\ConfigAbonnementType', $configAbonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configAbonnement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Enregistrement réussie.');
            return $this->redirectToRoute('configabonnement_index');
        }

        return $this->render('superadmin/configabonnement/new.html.twig', array(
            'configAbonnement' => $configAbonnement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a configAbonnement entity.
     *
     * @Route("/affichage/abonnement/{id}", name="configabonnement_show")
     * @Method("GET")
     */
    public function showAction(ConfigAbonnement $configAbonnement, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN', 'ROLE_FNS_ADMIN', 'ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($configAbonnement);

        return $this->render('superadmin/configabonnement/show.html.twig', array(
            'configAbonnement' => $configAbonnement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a configAbonnement demande entity.
     *
     * @Route("/demande/abonnement/{id}", name="configabonnement_show_demande")
     * @Method("GET")
     */
    public function showDemandeAction(ConfigAbonnementSociete $abonnementSociete, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        if (!is_null($abonnementSociete->getFichierPaie()) || $abonnementSociete->getFichierPaie() !== '') {
            $fichierPaie = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/uploads/paiements/' . $abonnementSociete->getFichierPaie();
        } else {
            $fichierPaie = '';
        }

        $editForm = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType2', $abonnementSociete);
        $editForm->handleRequest($request);


        return $this->render('superadmin/configabonnement/showDemandeSoc.html.twig', array(
            'configAbonnement' => $abonnementSociete,
            'fichierPaie' => $fichierPaie,
            'form' => $editForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing configAbonnementSociete by fns admin entity.
     *
     * @Route("/edit/demande/abonnement/by/fns/admin/{id}", name="activation_configabonnementsociete_edit_by_fns_admin")
     * @Method({"GET", "POST"})
     */
    public function activationEditDemandeAction(Request $request, ConfigAbonnementSociete $configAbonnementSociete)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $configAbonnementSociete->getSociete();


        $editForm = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType2', $configAbonnementSociete);
        $editForm->handleRequest($request);

        $ExisteSocAbonnementActif = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findOneBy(['societe' => $soc, 'estActif' => 1, 'estSupprimer' => 0], ['createdAt' => 'DESC']);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // un abonnement est déja actif
            if ($ExisteSocAbonnementActif != null)
            {
                // Comme un abonnement est deja actif, On verifie l'etat de la demande
                if (!$configAbonnementSociete->getEstActif()) {
                    // l'abonnement n'est pas actif, donc sais une ACTIVATION, or un abonnement est deja actif, donc ce n'est pas possible de l'activer
                    $request->getSession()->getFlashBag()->add('avertir', 'Désolé, Un abonnement est déja actif.');
                    return $this->redirectToRoute('configabonnement_show_demande', array('id' => $configAbonnementSociete->getId()));
                } else {
                    // l'abonnement est actif, donc sais une DEACTIVATION
                    $configAbonnementSociete->setEstActif(false);
                    $configAbonnementSociete->setUpdateBy($this->getUser()->getSlug());
                    $configAbonnementSociete->setUpdateAt(new \DateTime());

                    $configAbonnementSociete->setEstSupprimer(0);
                    $configAbonnementSociete->setEtatDemande(0);
                    $this->getDoctrine()->getManager()->flush();

                    $request->getSession()->getFlashBag()->add('avertir', 'Suspenssion réussie.');
                    return $this->redirectToRoute('configabonnement_show_demande', array('id' => $configAbonnementSociete->getId()));

                }

            } else {
                // On verifie si la version d'essai n'est pas redemander
                $typeAbonnement=$configAbonnementSociete->getTypeAbonnement()->getId();
                if ($soc->getDejaEssayer()==1 and $typeAbonnement == 4)
                {
                    $request->getSession()->getFlashBag()->add('avertir', 'La version d\'essaie est deja essayer.');
                    return $this->redirectToRoute('configabonnement_show_demande', array('id' => $configAbonnementSociete->getId()));

                } else
                {

                    // implique qu'aucun abonnement n'est encore actif

                    $duree = $configAbonnementSociete->getTypeAbonnement()->getNombreJour();
                    $configAbonnementSociete->setDebutAbonnement(new \DateTime());
                    $configAbonnementSociete->setFinAbonnement(new \DateTime());

                    // Ajout de la durée au date debut pour avoir date fin abonnnement
                    date_add($configAbonnementSociete->getFinAbonnement(), date_interval_create_from_date_string($duree . 'days'));
                    $configAbonnementSociete->setUpdateBy($this->getUser()->getSlug());
                    $configAbonnementSociete->setUpdateAt(new \DateTime());

                    $configAbonnementSociete->setEstSupprimer(0);
                    $configAbonnementSociete->setEtatDemande(0);
                    $configAbonnementSociete->setEstActif(1);

                    $this->getDoctrine()->getManager()->flush();

                    $request->getSession()->getFlashBag()->add('success', 'Activation de l\'abonnement réussie.');
                    return $this->redirectToRoute('configabonnement_show_demande', array('id' => $configAbonnementSociete->getId()));

                }
            }

        }

        return $this->render('configabonnementsociete/edit.html.twig', array(
            'configAbonnementSociete' => $configAbonnementSociete,
            'edit_form' => $editForm->createView(),
        ));
    }


    /**
     * @Route("/recuperer/liste/demande/pour/autoriser/attente", options={"expose"=true}, name="demande_attente_autoriser")
     */
    public function getDemandesAttentesAutoriser(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $monId = $request->get('monId');
            $demandesAbonnements = null;

            if ($monId == "demandeAttente") {
                $demandesAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findBy(['etatDemande' => 1, 'estActif' => 0, 'estSupprimer' => 0], ['createdAt' => 'DESC']);

            } elseif ($monId == "demandeAutoriser") {
                $demandesAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findBy(['etatDemande' => 0, 'estActif' => 1, 'estSupprimer' => 0], ['createdAt' => 'DESC']);
            }

            return $this->render('superadmin/configabonnement/demandeliste.html.twig', array(
                'demandesAbonnements' => $demandesAbonnements,
            ));
        }
    }


    /**
     * Displays a form to edit an existing configAbonnement entity.
     *
     * @Route("/{id}/edit", name="configabonnement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigAbonnement $configAbonnement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN', 'ROLE_FNS_ADMIN', 'ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($configAbonnement);
        $editForm = $this->createForm('ConfigBundle\Form\ConfigAbonnementType', $configAbonnement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Modification réussie.');
            return $this->redirectToRoute('configabonnement_index');
        }

        return $this->render('superadmin/configabonnement/edit.html.twig', array(
            'configAbonnement' => $configAbonnement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configAbonnement entity.
     *
     * @Route("/{id}", name="configabonnement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigAbonnement $configAbonnement)
    {
        $form = $this->createDeleteForm($configAbonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configAbonnement);
            $em->flush();
        }

        return $this->redirectToRoute('configabonnement_index');
    }

    /**
     * Creates a form to delete a configAbonnement entity.
     *
     * @param ConfigAbonnement $configAbonnement The configAbonnement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigAbonnement $configAbonnement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configabonnement_delete', array('id' => $configAbonnement->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Supprimer abonnement by setEstSupprimmer.
     *
     * @Route("/supprimmer/abonnement/par/admin/{id}", name="supprimmer_abonnement_par_admin")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ConfigAbonnement $configAbonnement, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN', 'ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();


        if ($configAbonnement->getEstSupprimer()) {
            $configAbonnement->setEstSupprimer(false);
            $configAbonnement->setUpdateBy($this->getUser()->getSlug());
            $configAbonnement->setUpdateAt(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', ' Annulation de suppression réussie.');
        } else {
            $configAbonnement->setEstSupprimer(true);
            $configAbonnement->setUpdateBy($this->getUser()->getSlug());
            $configAbonnement->setUpdateAt(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        }

        return $this->redirectToRoute('configabonnement_index');
    }


    /**
     * show and displays a societe entity ifu or register of selling.
     *
     * @Route("/{id}/activer/type/abonnement/par/superadmin", name="activer_type_bonnement")
     * @Method({"GET", "POST"})
     */

    public function activerTypeAbonnement(Request $request, ConfigAbonnement $configAbonnement)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN', 'ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        if (!$configAbonnement->getEstSupprimer()) {
            if ($configAbonnement->getEstActif()) {
                $configAbonnement->setEstActif(false);
                $configAbonnement->setUpdateBy($this->getUser()->getSlug());
                $configAbonnement->setUpdateAt(new \DateTime());
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Désactivation réussie.');
                return $this->redirectToRoute('configabonnement_index');
            } else {
                $configAbonnement->setEstActif(true);
                $configAbonnement->setUpdateBy($this->getUser()->getSlug());
                $configAbonnement->setUpdateAt(new \DateTime());
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Activation réussie.');
                return $this->redirectToRoute('configabonnement_index');
            }
        } else {
            $request->getSession()->getFlashBag()->add('avertir', 'Désolé, ce produit est supprimé.');
            return $this->redirectToRoute('configabonnement_index');
        }
    }
}
