<?php

namespace OperationsClientBundle\Controller;

use OperationsClientBundle\Entity\ClientPaiement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Clientpaiement controller.
 *
 * @Route("clientpaiement")
 */
class ClientPaiementController extends Controller
{
    /**
     * Lists all clientPaiement entities.
     *
     * @Route("/", name="clientpaiement_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $clientPaiements = $em->getRepository('OperationsClientBundle:ClientPaiement')->liste($soc);
        return $this->render('clientpaiement/index.html.twig', array(
            'clientPaiements' => $clientPaiements,
        ));
    }

    /**
     * Creates a new clientPaiement entity.
     *
     * @Route("/new", name="clientpaiement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $clientPaiement = new Clientpaiement();
        $form = $this->createForm('OperationsClientBundle\Form\ClientPaiementType', $clientPaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $clientPaiement->setCreated(new \DateTime());
            $clientPaiement->setCreatedBy($this->getUser()->getSlug());
            $clientPaiement->setEstSupprimer(false);

            $em->persist($clientPaiement);
            $em->flush();

            return $this->redirectToRoute('clientpaiement_show', array('id' => $clientPaiement->getId()));
        }

        return $this->render('clientpaiement/new.html.twig', array(
            'clientPaiement' => $clientPaiement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a clientPaiement entity.
     *
     * @Route("/{id}", name="clientpaiement_show")
     * @Method("GET")
     */
    public function showAction(Request $request,ClientPaiement $clientPaiement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($clientPaiement);

        return $this->render('clientpaiement/show.html.twig', array(
            'clientPaiement' => $clientPaiement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing clientPaiement entity.
     *
     * @Route("/{id}/edit", name="clientpaiement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ClientPaiement $clientPaiement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || !$this->get('security.authorization_checker')->isGranted(['ROLE_CAISSE'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($clientPaiement);
        $editForm = $this->createForm('OperationsClientBundle\Form\ClientPaiementType', $clientPaiement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $clientPaiement->setUpdateBy($this->getUser()->getSlug());
            $clientPaiement->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('clientpaiement_edit', array('id' => $clientPaiement->getId()));
        }

        return $this->render('clientpaiement/edit.html.twig', array(
            'clientPaiement' => $clientPaiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a clientPaiement entity.
     *
     * @Route("/{id}", name="clientpaiement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ClientPaiement $clientPaiement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($clientPaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clientPaiement);
            $em->flush();
        }

        return $this->redirectToRoute('clientpaiement_index');
    }

    /**
     * Creates a form to delete a clientPaiement entity.
     *
     * @param ClientPaiement $clientPaiement The clientPaiement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ClientPaiement $clientPaiement)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientpaiement_delete', array('id' => $clientPaiement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Supprimer ClientPaiement by setEstSupprimmer.
     *
     * @Route("/supprimmer/client/paiement/{id}", name="supprimmer_client_paiement")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ClientPaiement $clientPaiement, Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CAISSE'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $clientPaiement->setEstSupprimer(true);

        $clientPaiement->setUpdateBy($this->getUser()->getSlug());
        $clientPaiement->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        return $this->redirectToRoute('clientpaiement_index');

    }



}
