<?php

namespace StockBundle\Controller;

use StockBundle\Entity\StockService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Stockservice controller.
 *
 * @Route("stockservice")
 */
class StockServiceController extends Controller
{
    /**
     * Lists all stockService entities.
     *
     * @Route("/", name="stockservice_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $stockServices = $em->getRepository('StockBundle:StockService')->findBy(['estSupprimer'=>0,'societe'=>$soc], ['created' => 'DESC']);

        return $this->render('stockservice/index.html.twig', array(
            'stockServices' => $stockServices,
        ));
    }


    /**
     * Supprimer stockService by setEstSupprimmer.
     *
     * @Route("/supprimmer/stock/service/{id}", name="supprimmer_stock_service")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(StockService $stockService, Request $request)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $stockService->setEstSupprimer(true);

        $stockService->setUpdateBy($this->getUser()->getSlug());
        $stockService->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('stockservice_index');

    }


    /**
     * Creates a new stockService entity.
     *
     * @Route("/new", name="stockservice_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $stockService = new Stockservice();
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $soc,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $reference = $this->get('code_generate')->genererReferenceService($soc->getId());
            $stockService->setReference($reference);
        }
        $form = $this->createForm('StockBundle\Form\StockServiceType', $stockService, ['reference_genere' => $estGenere]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockService->setSociete($soc);
            $stockService->setCreated(new \DateTime());
            $stockService->setCreatedBy($this->getUser()->getSlug());
            $stockService->setEstSupprimer(0);

            $em->persist($stockService);
            $em->flush();

            return $this->redirectToRoute('stockservice_show', array('id' => $stockService->getId()));
        }

        return $this->render('stockservice/new.html.twig', array(
            'stockService' => $stockService,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stockService entity.
     *
     * @Route("/{id}", name="stockservice_show")
     * @Method("GET")
     */
    public function showAction(StockService $stockService,Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockService);
        $prixUnitaireTTC = $this->get('stock_operations')->calculerPrixUnitaireTTC($stockService);

        return $this->render('stockservice/show.html.twig', array(
            'stockService' => $stockService,
            'prixUnitaireTTC' => $prixUnitaireTTC,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stockService entity.
     *
     * @Route("/{id}/edit", name="stockservice_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StockService $stockService)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockService);
        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $societe,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $reference = $this->get('code_generate')->genererReferenceService($societe->getId());
            $stockService->setReference($reference);
        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');
        }

        $editForm = $this->createForm('StockBundle\Form\StockServiceType', $stockService, ['reference_genere' => $estGenere]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $stockService->setUpdateBy($this->getUser()->getSlug());
            $stockService->setUpdatedAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stockservice_show', array('id' => $stockService->getId()));
        }

        return $this->render('stockservice/edit.html.twig', array(
            'stockService' => $stockService,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stockService entity.
     *
     * @Route("/{id}", name="stockservice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StockService $stockService)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($stockService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stockService);
            $em->flush();
        }

        return $this->redirectToRoute('stockservice_index');
    }

    /**
     * Creates a form to delete a stockService entity.
     *
     * @param StockService $stockService The stockService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StockService $stockService)
    {
        
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockservice_delete', array('id' => $stockService->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
