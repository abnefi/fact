<?php

namespace ConfigBundle\Controller;

use ConfigBundle\Entity\ConfigAgence;
use OperationsClientBundle\Entity\ClientFacture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Configagence controller.
 *
 * @Route("configagence")
 */
class ConfigAgenceController extends Controller
{

    /**
     * Lists all configAgence entities.
     *
     * @Route("/", name="configagence_index")
     * @Method("GET")
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
        $em = $this->getDoctrine()->getManager();

        $configAgences = $em->getRepository('ConfigBundle:ConfigAgence')->findBy(['estSupprimer'=>0,'societe'=>$soc]);

        return $this->render('configagence/index.html.twig', array(
            'configAgences' => $configAgences,
        ));
    }

    /**
     * Displays a form to edit an existing clientPaiement entity.
     *
     * @Route("/edit/liste", name="configagence_editliste")
     * @Method({"GET", "POST"})
     */
    public function editListeAgenceAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();
        $editListeForm = $this->createForm('ConfigBundle\Form\ConfigSocieteAgencesType', $societe);
        $editListeForm->handleRequest($request);


        if ($editListeForm->isSubmitted() && $editListeForm->isValid()) {
            $agences = $societe->getAgences();
            foreach ($agences as $agence) {
                $agence->setSociete($societe);
                $agence->setUpdateBy($this->getUser()->getSlug());
                $agence->setCreatedBy($this->getUser()->getSlug());
                $agence->setUpdateAt(new \DateTime());
            }
//
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Enregistrement effectué avec succès');
            return $this->redirectToRoute('configagence_index');
        }
        $agences = $societe->getAgences();

        return $this->render('configagence/editListe.html.twig', array(
            'societe' => $societe,
            'form' => $editListeForm->createView(),
            'agences' => $agences,
        ));
    }

    /**
     * Creates a new configAgence entity.
     *
     * @Route("/new", name="configagence_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $user = $this->getUser();

        $configAgence = new Configagence();

        $code = $this->get('code_generate')->genererCodeAgence($user->getAgence()->getSociete());
        $configAgence->setCode($code);

        $form = $this->createForm('ConfigBundle\Form\ConfigAgenceType', $configAgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $configAgence->setCreated(new \DateTime());
            $configAgence->setCreatedBy($this->getUser()->getSlug());
            $configAgence->setEstSupprimer(0);

            $em->persist($configAgence);
            $em->flush();

            return $this->redirectToRoute('configagence_show', array('id' => $configAgence->getId()));
        }

        return $this->render('configagence/new.html.twig', array(
            'configAgence' => $configAgence,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a configAgence entity.
     *
     * @Route("/{id}", name="configagence_show")
     * @Method("GET")
     */
    public function showAction(Request $request,ConfigAgence $configAgence)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($configAgence);

        return $this->render('configagence/show.html.twig', array(
            'configAgence' => $configAgence,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing configAgence entity.
     *
     * @Route("/{id}/edit", name="configagence_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigAgence $configAgence)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($configAgence);
        $editForm = $this->createForm('ConfigBundle\Form\ConfigAgenceType', $configAgence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $configAgence->setUpdateBy($this->getUser()->getSlug());
            $configAgence->setUpdateAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('configagence_edit', array('id' => $configAgence->getId()));
        }

        return $this->render('configagence/edit.html.twig', array(
            'configAgence' => $configAgence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configAgence entity.
     *
     * @Route("/{id}", name="configagence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigAgence $configAgence)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $form = $this->createDeleteForm($configAgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configAgence);
            $em->flush();
        }

        return $this->redirectToRoute('configagence_index');
    }

    /**
     * Creates a form to delete a configAgence entity.
     *
     * @param ConfigAgence $configAgence The configAgence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigAgence $configAgence)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configagence_delete', array('id' => $configAgence->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Supprimer ConfigAgence by setEstSupprimmer.
     *
     * @Route("/supprimmer/config/agence", options={"expose"=true}, name="supprimmer_config_Agence")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $monCode=$request->request->get('codeAgenceCliquer');
        $em = $this->getDoctrine()->getManager();
        $configAgence = $em->getRepository('ConfigBundle:ConfigAgence')->findOneBy(['code'=>$monCode]);

        if ($configAgence->getEstSupprimer())
        {
            $configAgence->setEstSupprimer(false);
            $configAgence->setUpdateBy($this->getUser()->getSlug());
            $configAgence->setUpdateAt(new \DateTime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Annulation de Suppression réussie.');
            return $this->redirectToRoute('configagence_editliste');
        } else {

            $configAgence->setEstSupprimer(true);
            $configAgence->setUpdateBy($this->getUser()->getSlug());
            $configAgence->setUpdateAt(new \DateTime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
            return $this->redirectToRoute('configagence_editliste');
        }


    }


    /**
     * Désactivation Agence .
     *
     * @Route("/desactivation/de/agence/{id}", name="desactivation_de_agence")
     * @Method({"GET", "POST"})
     */
    public function desactivationDagence(ConfigAgence $configAgence, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        $configAgence->setEstActif(false);
        $configAgence->setEtatDemande(false);

        $configAgence->setUpdateBy($this->getUser()->getSlug());
        $configAgence->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Désactivation  réussie.');
        return $this->redirectToRoute('configagence_index');

    }

    /**
     * Demande d'activation de d'agence
     *
     * @Route("/{id}/demande/activation/agence", name="demande_activer_agence")
     * @Method({"GET", "POST"})
     */
    public function demandeActivationAgence(Request $request, ConfigAgence $configAgence)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        if (!$configAgence->getEstSupprimer()) {
            if (!$configAgence->getEtatDemande()) {
                $configAgence->setEtatDemande(true);
                $configAgence->setUpdateBy($this->getUser()->getSlug());
                $configAgence->setUpdateAt(new \DateTime());
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Votre demande d\'activation est envoyée. Merci de patienter');
                return $this->redirectToRoute('configagence_index');
            } else {

                $request->getSession()->getFlashBag()->add('avertir', 'Une demande d\'activation est déja en cours. Merci de patienter');
                return $this->redirectToRoute('configagence_index');
            }
        } else
        {
            $request->getSession()->getFlashBag()->add('fail', 'Désolé, ce utilisateur est supprimé.');
            return $this->redirectToRoute('configagence_index');
        }

    }


}
