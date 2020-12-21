<?php

namespace StockBundle\Controller;

use StockBundle\Entity\StockInventaire;
use StockBundle\Entity\StockInventaireDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\FosUser;

/**
 * Stockinventaire controller.
 *
 * @Route("stockinventaire")
 */
class StockInventaireController extends Controller
{
    /**
     * Lists all stockInventaire entities.
     *
     * @Route("/", name="stockinventaire_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();

        $stockInventaires = $em->getRepository('StockBundle:StockInventaire')->findBy(['estSupprime'=>0,'societe'=>$societe], ['created' => 'DESC']);

        return $this->render('stockinventaire/index.html.twig', array(
            'stockInventaires' => $stockInventaires,
        ));
    }



    /**
     * Supprimer stockInventaire by setEstSupprimmer.
     *
     * @Route("/supprimmer/stock/inventaire/{id}", name="supprimmer_stock_Inventaire")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(StockInventaire $stockInventaire, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $stockInventaire->setEstSupprime(true);

        $stockInventaire->setUpdateBy($this->getUser()->getSlug());
        $stockInventaire->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('stockinventaire_index');

    }

    /**
     * Creates a new stockInventaire entity.
     *
     * @Route("/new", name="stockinventaire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();
        $stockInventaire = new Stockinventaire();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $societe,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $reference = $this->get('code_generate')->genererReferenceInventaire($societe->getId());
            $stockInventaire->setReferenceInventaire($reference);
        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');
        }

        $form = $this->createForm('StockBundle\Form\StockInventaireType', $stockInventaire);
        $form->handleRequest($request);

        $stockInventaire->setCreated(new \DateTime());
        $stockInventaire->setCreatedBy($this->getUser()->getSlug());
        $stockInventaire->setDateInventaire(new \DateTime());
        $stockInventaire->setUser($this->getUser());
        $stockInventaire->setSociete($societe);


        $etat = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'BR','estSupprimer'=>0]);
        $stockInventaire->setEtat($etat);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stockInventaire);

            //ajout des articles
            $articles = $em->getRepository('StockBundle:StockArticle')->findBy(['estSupprimer'=>0,'societe'=>$societe]);
            foreach ($articles as $article) {
                $detail = new StockInventaireDetail();
                $detail->setInventaire($stockInventaire);
                $detail->setArticle($article);
                $detail->setCreated(new \DateTime());
                $detail->setCreatedBy($this->getUser()->getSlug());
                $detail->setStockTheorique($article->getStockDisponible());
                $detail->setStockReel($article->getStockDisponible());
                $detail->setEstSupprimer(0);

                $em->persist($detail);
            }

            $em->flush();

            return $this->redirectToRoute('stockinventaire_edit', array('id' => $stockInventaire->getId()));
        }

        return $this->render('stockinventaire/new.html.twig', array(
            'stockInventaire' => $stockInventaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stockInventaire entity.
     *
     * @Route("/{id}", name="stockinventaire_show")
     * @Method("GET")
     */
    public function showAction(Request $request,StockInventaire $stockInventaire)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockInventaire);

        return $this->render('stockinventaire/show.html.twig', array(
            'stockInventaire' => $stockInventaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stockInventaire entity.
     *
     * @Route("/{id}/edit", name="stockinventaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StockInventaire $stockInventaire)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockInventaire);
        $editForm = $this->createForm('StockBundle\Form\StockInventaireEditType', $stockInventaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $etat = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'EC']);
            $stockInventaire->setEtat($etat);

            $stockInventaire->setUpdateBy($this->getUser()->getSlug());
            $stockInventaire->setUpdatedAt(new \DateTime());

            $em->flush();

            return $this->redirectToRoute('stockinventaire_show', array('id' => $stockInventaire->getId()));
        }
//        $detail = new StockInventaireDetail();
        return $this->render('stockinventaire/edit.html.twig', array(
            'stockInventaire' => $stockInventaire,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Validation of stockInventaire entity.
     *
     * @Route("/{id}/valider", name="stockinventaire_valider")
     * @Method({"GET", "POST"})
     */
    public function validerAction(Request $request, StockInventaire $stockInventaire)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $details = $stockInventaire->getDetails();
        foreach ($details as $detail) {
            $article = $detail->getArticle();
            $article->setStockDisponible($detail->getStockReel());
            $etat = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'VA','estSupprimer'=>0]);
            $stockInventaire->setEtat($etat);
            $article->setCreated(new \DateTime());
            $article->setCreatedBy($this->getUser()->getSlug());
            $article->setEstSupprimer(0);

            $em->persist($article);
        }
        $stockInventaire->setEstValide(true);
        $stockInventaire->setDateValidation(new \DateTime());
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Validation effectuée avec succès');

        return $this->redirectToRoute('stockinventaire_show', array('id' => $stockInventaire->getId()));
    }

    /**
     * Deletes a stockInventaire entity.
     *
     * @Route("/{id}", name="stockinventaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StockInventaire $stockInventaire)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($stockInventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stockInventaire);
            $em->flush();
        }

        return $this->redirectToRoute('stockinventaire_index');
    }

    /**
     * Creates a form to delete a stockInventaire entity.
     *
     * @param StockInventaire $stockInventaire The stockInventaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StockInventaire $stockInventaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockinventaire_delete', array('id' => $stockInventaire->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
