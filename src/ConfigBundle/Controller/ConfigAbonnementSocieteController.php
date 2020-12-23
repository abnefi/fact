<?php

namespace ConfigBundle\Controller;

use ConfigBundle\Entity\ConfigAbonnement;
use ConfigBundle\Entity\ConfigAbonnementSociete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Configabonnementsociete controller.
 *
 * @Route("configabonnementsociete")
 */
class ConfigAbonnementSocieteController extends Controller
{
    /**
     * Lists all configAbonnementSociete entities.
     *
     * @Route("/", name="configabonnementsociete_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();
        $etatEssaie = $soc->getDejaEssayer();

        $configAbonnements = $em->getRepository('ConfigBundle:ConfigAbonnement')->findBy(['estActif' => true, 'estSupprimer' => false]);

        $configAbonnementSocietes = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findBy(['societe' => $soc, 'estSupprimer' => false], ['createdAt' => 'DESC']);

        $configAbonnementSociete = new Configabonnementsociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType', $configAbonnementSociete, ['etatEssaie'=>$etatEssaie]);
        $form->handleRequest($request);

        return $this->render('configabonnementsociete/index.html.twig', array(
            'configAbonnementSocietes' => $configAbonnementSocietes,
            'configAbonnementSociete' => $configAbonnementSociete,
            'configAbonnements' => $configAbonnements,
            'etatEssaie' => $etatEssaie,
            'form' => $form->createView()
        ));
    }

    /**
     * Lists all configAbonnementSociete entities.
     *
     * @Route("/historique/abonnement", name="config_abonnement_societe_historique")
     * @Method("GET")
     */

    public function HistoriqueAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $soc = $this->getUser()->getAgence()->getSociete();

        $configAbonnementSocietes = $em->getRepository('ConfigBundle:ConfigAbonnementSociete')->findBy(['societe' => $soc, 'estSupprimer' => false], ['createdAt' => 'DESC']);

        return $this->render('configabonnementsociete/indexHistorique.html.twig', array(
            'configAbonnementsSocietes' => $configAbonnementSocietes,

        ));
    }


    /**
     * Supprimer abonnementSociete by setEstSupprimmer.
     *
     * @Route("/supprimmer/abonnement/societe/par/admin/clt/{id}", name="supprimmer_abonnement_societe_par_admin_clt")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ConfigAbonnementSociete $configAbonnement, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_FNS_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();


        if ($configAbonnement->getEstSupprimer())
        {
            $configAbonnement->setEstSupprimer(false);
            $configAbonnement->setUpdateBy($this->getUser()->getSlug());
            $configAbonnement->setUpdateAt(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', ' Désactivation de suppression réussie.');
        } else
        {
            $configAbonnement->setEstSupprimer(true);
            $configAbonnement->setUpdateBy($this->getUser()->getSlug());
            $configAbonnement->setUpdateAt(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        }

        return $this->redirectToRoute('config_abonnement_societe_historique');
    }

    /**
     * Creates a new configAbonnementSociete entity.
     *
     * @Route("/new", name="configabonnementsociete_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $soc = $this->getUser()->getAgence()->getSociete();
        $etatEssaie = $soc->getDejaEssayer();

        $configAbonnementSociete = new Configabonnementsociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType', $configAbonnementSociete, ['etatEssaie'=>$etatEssaie]);
        $form->handleRequest($request);


        if ($form->isSubmitted())
        {
            // Vérifier si c'est pdf
            $typefichier = $form->get('fichierPaie')->getData()->getMimeType();

            if ($typefichier != "application/pdf")
            {
                $request->getSession()->getFlashBag()->add('fail', 'Désolé, Veuillez selectionner un fichier de type PDF.');
                return $this->redirectToRoute('configabonnementsociete_index');
            } else
            {
                if ($form->isValid())
                {
                    $paiementfile = $form->get('fichierPaie')->getData();

                    // cette condition est nécessaire car le champ '$paiementfile' n'est pas obligatoire
                    // donc le fichier PDF ne doit être traité que lorsqu'un fichier est téléchargé

                    if ($paiementfile) {
                        $originalFilename = pathinfo($paiementfile->getClientOriginalName(), PATHINFO_FILENAME);
                        // ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$paiementfile->guessExtension();

                        // Déplacer le fichier dans le répertoire où sont stockées les fichier de paiement
                        try {
                            $paiementfile->move(
                                $this->getParameter('repertoire_paiements'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            // ... gère l'exception si quelque chose se produit pendant le téléchargement du fichier
                        }
                        // met à jour la propriété '$originalFilename' pour stocker le nom du fichier PDF
                        // au lieu de son contenu
                        $configAbonnementSociete->setFichierPaie($newFilename);
                    }
                    $em = $this->getDoctrine()->getManager();
                    $configAbonnementSociete->setCreatedBy($this->getUser()->getSlug());
                    $configAbonnementSociete->setCreatedAt(new \DateTime());
                    $configAbonnementSociete->setEtatDemande(true);
                    $configAbonnementSociete->setSociete($this->getUser()->getAgence()->getSociete());

                    $em->persist($configAbonnementSociete);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('success', 'Demande d\'activation réussie.');
                    return $this->redirectToRoute('config_abonnement_societe_historique');
                }
                else
                {
                    $request->getSession()->getFlashBag()->add('fail', 'Echec de demande d\'activation.');
                    return $this->redirectToRoute('configabonnementsociete_index');
                }
            }

        }



        return $this->render('configabonnementsociete/new.html.twig', array(
            'configAbonnementSociete' => $configAbonnementSociete,
            'form' => $form->createView(),
        ));
    }


    /**
     *
     * @Route("/{id}/abonnement/infos/get/prix/duree", options={"expose"=true}, name="get_prix_duree_for_abonnement")
     * @Method({"GET", "POST"})
     */
    public function getPrixDureeForAbonnementAction(Request $request, ConfigAbonnement $configAbonnement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_FNS_ADMIN','ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $m_duree=$configAbonnement->getNombreJour();
        $m_prix=$configAbonnement->getPrix();

        $responseArray = [];
        $responseArray['prix_abonnement'] = $m_prix;
        $responseArray['duree_abonnement'] = $m_duree;

        return new JsonResponse($responseArray);
    }


    /**
     * Finds and displays a configAbonnementSociete entity.
     *
     * @Route("/{id}", name="configabonnementsociete_show")
     * @Method("GET")
     */
    public function showAction(ConfigAbonnementSociete $configAbonnementSociete, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($configAbonnementSociete);

        return $this->render('configabonnementsociete/show.html.twig', array(
            'configAbonnement' => $configAbonnementSociete,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing configAbonnementSociete entity.
     *
     * @Route("/{id}/edit", name="configabonnementsociete_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigAbonnementSociete $configAbonnementSociete)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($configAbonnementSociete);
        $editForm = $this->createForm('ConfigBundle\Form\ConfigAbonnementSocieteType', $configAbonnementSociete);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('configabonnementsociete_edit', array('id' => $configAbonnementSociete->getId()));
        }

        return $this->render('configabonnementsociete/edit.html.twig', array(
            'configAbonnementSociete' => $configAbonnementSociete,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configAbonnementSociete entity.
     *
     * @Route("/{id}", name="configabonnementsociete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigAbonnementSociete $configAbonnementSociete)
    {
        $form = $this->createDeleteForm($configAbonnementSociete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configAbonnementSociete);
            $em->flush();
        }

        return $this->redirectToRoute('configabonnementsociete_index');
    }

    /**
     * Creates a form to delete a configAbonnementSociete entity.
     *
     * @param ConfigAbonnementSociete $configAbonnementSociete The configAbonnementSociete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigAbonnementSociete $configAbonnementSociete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configabonnementsociete_delete', array('id' => $configAbonnementSociete->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
