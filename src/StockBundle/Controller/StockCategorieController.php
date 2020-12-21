<?php

namespace StockBundle\Controller;

use StockBundle\Entity\StockCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Stockcategorie controller.
 *
 * @Route("stockcategorie")
 */
class StockCategorieController extends Controller
{
    /**
     * Lists all stockCategorie entities.
     *
     * @Route("/", name="stockcategorie_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();

        $stockCategories = $em->getRepository('StockBundle:StockCategorie')->findBy(array("estSupprimer" => false,'societe'=>$societe));

        return $this->render('stockcategorie/index.html.twig', array(
            'stockCategories' => $stockCategories,
        ));
    }


    /**
     * Supprimer stockCategorie by setEstSupprimmer.
     *
     * @Route("/supprimmer/stock/categorie/{id}", name="supprimmer_stock_categorie")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(StockCategorie $stockCategorie, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $stockCategorie->setEstSupprimer(true);

        $stockCategorie->setUpdateBy($this->getUser()->getSlug());
        $stockCategorie->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('stockcategorie_index');

    }



    /**
     * Creates a new stockCategorie entity.
     *
     * @Route("/new", name="stockcategorie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $societe = $this->getUser()->getAgence()->getSociete();

        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $stockCategorie = new Stockcategorie();
        $form = $this->createForm('StockBundle\Form\StockCategorieType', $stockCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $libelle = $stockCategorie->getLibelle();

            $oldlibellecategorie = $em->getRepository('StockBundle:StockCategorie')->findOneBy(['libelle' => $libelle, 'societe'=>$societe]);
            if ($oldlibellecategorie != null) {
                $error = new FormError('Cette Catégorie existe déjà');
                $form->addError($error);
                $request->getSession()->getFlashBag()->add('avertir', 'Cette Catégorie existe déjà');
                goto END;
            }


            $stockCategorie->setCreatedAt(new \DateTime());
            $stockCategorie->setCreatedBy($this->getUser()->getSlug());
            $stockCategorie->setEstSupprimer(0);
            $stockCategorie->setSociete($societe);

            $em->persist($stockCategorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'La catégorie à bien été ajouté');

            return $this->redirectToRoute('stockcategorie_show', array('id' => $stockCategorie->getId()));
        }

        END:
        return $this->render('stockcategorie/new.html.twig', array(
            'stockCategorie' => $stockCategorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stockCategorie entity.
     *
     * @Route("/{id}", name="stockcategorie_show")
     * @Method("GET")
     */
    public function showAction(Request $request,StockCategorie $stockCategorie)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockCategorie);

        return $this->render('stockcategorie/show.html.twig', array(
            'stockCategorie' => $stockCategorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stockCategorie entity.
     *
     * @Route("/{id}/edit", name="stockcategorie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StockCategorie $stockCategorie)
    {
        $societe = $this->getUser()->getAgence()->getSociete();

        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($stockCategorie);
        $editForm = $this->createForm('StockBundle\Form\StockCategorieType', $stockCategorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $libelle = $stockCategorie->getLibelle();

            $oldlibellecategorie = $em->getRepository('StockBundle:StockCategorie')->findOneBy(['libelle' => $libelle, 'societe'=>$societe]);

            if ($oldlibellecategorie != null) {

                if($oldlibellecategorie->getId() !== $stockCategorie->getId())
                {
                    $error = new FormError('Cette Catégorie existe déjà');
                    $editForm->addError($error);
                    $request->getSession()->getFlashBag()->add('avertir', 'Cette Catégorie existe déjà');
                    goto END;
                }

            }

            $stockCategorie->setUpdateBy($this->getUser()->getSlug());
            $stockCategorie->setUpdateAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'La catégorie à bien été modifié');
            return $this->redirectToRoute('stockcategorie_show', array('id' => $stockCategorie->getId()));
        }

        END:
        return $this->render('stockcategorie/edit.html.twig', array(
            'stockCategorie' => $stockCategorie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stockCategorie entity.
     *
     * @Route("/delete/{id}", name="stockcategorie_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, StockCategorie $stockCategorie)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('acces', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
//        $form = $this->createDeleteForm($stockCategorie);
//        $form->handleRequest($request);


            $em = $this->getDoctrine()->getManager();
            $stockCategorie->setEstSupprimer(true);
            $em->persist($stockCategorie);
            $em->flush();

        return $this->redirectToRoute('stockcategorie_index');
    }

    /**
     * Creates a form to delete a stockCategorie entity.
     *
     * @param StockCategorie $stockCategorie The stockCategorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StockCategorie $stockCategorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stockcategorie_delete', array('id' => $stockCategorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
