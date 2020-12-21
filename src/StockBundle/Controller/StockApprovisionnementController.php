<?php

namespace StockBundle\Controller;

use StockBundle\Entity\StockApprovisionnement;
use StockBundle\Entity\StockApprovisionnementDetail;
use StockBundle\Form\StockApprovisionnementDetailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Stockapprovisionnement controller.
 *
 * @Route("stockapprovisionnement")
 */
class StockApprovisionnementController extends Controller
{
    /**
     * Lists all stockApprovisionnement entities.
     *
     * @Route("/", name="stockapprovisionnement_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_USER','ROLE_ADMIN','ROLE_AGENT']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();

        $stockApprovisionnements = $em->getRepository('StockBundle:StockApprovisionnement')->findBy(['estSupprimer'=>0,'societe'=>$societe], ['created' => 'DESC']);

        return $this->render('stockapprovisionnement/index.html.twig', array(
            'stockApprovisionnements' => $stockApprovisionnements,
        ));
    }


    /**
     * Supprimer stockApprovisionnement by setEstSupprimmer.
     *
     * @Route("/supprimmer/stock/stockApprovisionnement/{id}", name="supprimmer_stock_approvisionnement")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(StockApprovisionnement $stockApprovisionnement, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_USER','ROLE_ADMIN','ROLE_AGENT']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $stockApprovisionnement->setEstSupprimer(true);

        $stockApprovisionnement->setUpdateBy($this->getUser()->getSlug());
        $stockApprovisionnement->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');


        return $this->redirectToRoute('stockapprovisionnement_index');

    }


    /**
     * Creates a new stockApprovisionnement entity.
     *
     * @Route("/new", name="stockapprovisionnement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_USER','ROLE_ADMIN','ROLE_AGENT']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $stockApprovisionnement = new Stockapprovisionnement();

        $societe = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $societe,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $reference = $this->get('code_generate')->genererReferenceApprovisionnement($societe->getId());
            $stockApprovisionnement->setReference($reference);

        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');
        }

        $form = $this->createForm('StockBundle\Form\StockApprovisionnementType', $stockApprovisionnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userPublicId = $this->getUser()->getuserPublicId();

            $stockApprovisionnement->setCreated(new \DateTime());
            $stockApprovisionnement->setCreatedBy($this->getUser()->getSlug());

            $stockApprovisionnement->setSociete($societe);
            $stockApprovisionnement->setUserPublicId($userPublicId);
            $stockApprovisionnement->setEstSupprimer(0);

            $em->persist($stockApprovisionnement);
            $details = $stockApprovisionnement->getDetails();

            foreach ($details as $detail) {
                $detail->setCreatedBy($this->getUser()->getSlug());
                $detail->setEstSupprimer(0);
                $detail->setApprovisionnement($stockApprovisionnement);
            }
//            dump($detail);die();
            $em->flush();

            return $this->redirectToRoute('stockapprovisionnement_show', array('id' => $stockApprovisionnement->getId()));
        }

        return $this->render('stockapprovisionnement/new.html.twig', array(
            'stockApprovisionnement' => $stockApprovisionnement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stockApprovisionnement entity.
     *
     * @Route("/{id}", name="stockapprovisionnement_show")
     * @Method("GET")
     */
    public function showAction(Request $request,StockApprovisionnement $stockApprovisionnement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_USER','ROLE_ADMIN','ROLE_AGENT']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($stockApprovisionnement);
        $montantTotal = $this->get('stock_operations')->calculerMontantApprovisionnement($stockApprovisionnement);
        return $this->render('stockapprovisionnement/show.html.twig', array(
            'stockApprovisionnement' => $stockApprovisionnement,
            'montantTotal' => $montantTotal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stockApprovisionnement entity.
     *
     * @Route("/{id}/edit", name="stockapprovisionnement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StockApprovisionnement $stockApprovisionnement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_USER','ROLE_ADMIN','ROLE_AGENT']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockApprovisionnement);
        $editForm = $this->createForm('StockBundle\Form\StockApprovisionnementType', $stockApprovisionnement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $details = $stockApprovisionnement->getDetails();

            $stockApprovisionnement->setUpdateBy($this->getUser()->getSlug());
            $stockApprovisionnement->setUpdatedAt(new \DateTime());

            foreach ($details as $detail) {
                $detail->setApprovisionnement($stockApprovisionnement);

                $detail->setUpdateBy($this->getUser()->getSlug());
                $detail->setUpdatedAt(new \DateTime());
                $id = $detail->getId();
                if ($id == null){
                    $detail->setCreatedBy($this->getUser()->getSlug());
                    $detail->setEstSupprimer(0);
                }
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stockapprovisionnement_show', array('id' => $stockApprovisionnement->getId()));
        }

        return $this->render('stockapprovisionnement/edit.html.twig', array(
            'stockApprovisionnement' => $stockApprovisionnement,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stockApprovisionnement entity.
     *
     * @Route("/{id}", name="stockapprovisionnement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StockApprovisionnement $stockApprovisionnement)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_USER','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($stockApprovisionnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stockApprovisionnement);
            $em->flush();
        }

        return $this->redirectToRoute('stockapprovisionnement_index');
    }

    /**
     * Creates a form to delete a stockApprovisionnement entity.
     *
     * @param StockApprovisionnement $stockApprovisionnement The stockApprovisionnement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StockApprovisionnement $stockApprovisionnement)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockapprovisionnement_delete', array('id' => $stockApprovisionnement->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
