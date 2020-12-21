<?php

namespace StockBundle\Controller;

use StockBundle\Entity\StockArticle;
use StockBundle\Entity\StockProduit;
use StockBundle\Entity\StockService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Stockarticle controller.
 *
 * @Route("stockarticle")
 */
class StockArticleController extends Controller
{
    /**
     * Lists all stockArticle entities.
     *
     * @Route("/", name="stockarticle_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $stockArticles = $em->getRepository('StockBundle:StockArticle')->findBy(['estSupprimer'=>0,'societe'=>$soc], ['created' => 'DESC']);
        return $this->render('stockarticle/index.html.twig', array(
            'stockArticles' => $stockArticles,
        ));
    }


    /**
     * Supprimer stockArticle by setEstSupprimmer.
     *
     * @Route("/supprimmer/stock/article/{id}", name="supprimmer_stock_article")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(StockArticle $stockArticle, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('logout');
        }

        $em = $this->getDoctrine()->getManager();
        $stockArticle->setEstSupprimer(true);

        $stockArticle->setUpdateBy($this->getUser()->getSlug());
        $stockArticle->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('stockarticle_index');

    }


    /**
     * Creates a new stockArticle entity.
     *
     * @Route("/new", name="stockarticle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('logout');
        }
        $stockArticle = new StockArticle();
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $soc,'estSupprimer'=>0,'estGenere'=>1]);
        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $reference = $this->get('code_generate')->genererReferenceArticle($soc->getId());
            $stockArticle->setReference($reference);
        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');
        }

        $form = $this->createForm('StockBundle\Form\StockArticleType', $stockArticle,
            [
                'entity_manager' => $em,
                'reference_genere' => $estGenere
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $stockArticle->setSociete($soc);
            $stockArticle->setCreated(new \DateTime());
            $stockArticle->setCreatedBy($this->getUser()->getSlug());
            $stockArticle->setEstSupprimer(0);

            $em->persist($stockArticle);
            $em->flush();
            return $this->redirectToRoute('stockarticle_show', array('id' => $stockArticle->getId()));
        }

        return $this->render('stockarticle/new.html.twig', array(
            'stockArticle' => $stockArticle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stockArticle entity.
     *
     * @Route("/{id}", name="stockarticle_show")
     * @Method("GET")
     */
    public function showAction(Request $request,StockArticle $stockArticle)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('logout');
        }
        $deleteForm = $this->createDeleteForm($stockArticle);
        //Calcul du prix unitaire TTC
        $prixUnitaireTTC = $this->get('stock_operations')->calculerPrixUnitaireTTC($stockArticle);
        return $this->render('stockarticle/show.html.twig', array(
            'stockArticle' => $stockArticle,
            'prixUnitaireTTC' => $prixUnitaireTTC,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stockArticle entity.
     *
     * @Route("/{id}/edit", name="stockarticle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StockArticle $stockArticle)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('logout');
        }
        $deleteForm = $this->createDeleteForm($stockArticle);
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm('StockBundle\Form\StockArticleType', $stockArticle,
            [
                'entity_manager' => $em,
            ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $stockArticle->setUpdateBy($this->getUser()->getSlug());
            $stockArticle->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stockarticle_show', array('id' => $stockArticle->getId()));
        }

        return $this->render('stockarticle/edit.html.twig', array(
            'stockArticle' => $stockArticle,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stockArticle entity.
     *
     * @Route("/{id}", name="stockarticle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StockArticle $stockArticle)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('logout');
        }
        $form = $this->createDeleteForm($stockArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stockArticle);
            $em->flush();
        }

        return $this->redirectToRoute('stockarticle_index');
    }

    /**
     * Creates a form to delete a stockArticle entity.
     *
     * @param StockArticle $stockArticle The stockArticle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StockArticle $stockArticle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockarticle_delete', array('id' => $stockArticle->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
