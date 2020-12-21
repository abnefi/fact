<?php

namespace TiersBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use TiersBundle\Entity\TiersFournisseur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tiersfournisseur controller.
 *
 * @Route("tiersfournisseur")
 */
class TiersFournisseurController extends Controller
{
    /**
     * Lists all tiersFournisseur entities.
     *
     * @Route("/", name="tiersfournisseur_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $tiersFournisseurs = $em->getRepository('TiersBundle:TiersFournisseur')->findBy(['estSupprimer'=>0,'societe'=>$soc],['created'=>'DESC']);

        return $this->render('tiersfournisseur/index.html.twig', array(
            'tiersFournisseurs' => $tiersFournisseurs,
        ));
    }

    /**
     * Creates a new tiersFournisseur entity.
     *
     * @Route("/new", name="tiersfournisseur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $tiersFournisseur = new Tiersfournisseur();
        $soc = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $soc,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $code = $this->get('code_generate')->genererCodeFournisseur($soc->getId());
            $tiersFournisseur->setCode($code);
        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');

        }



        $form = $this->createForm('TiersBundle\Form\TiersFournisseurType', $tiersFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fournisseur = $request->request->get('tiersbundle_tiersfournisseur');
            $telephone = $fournisseur['telephone'];

            $search = array('+', '(', ')', '.');

            $replace = array('', '', '', '');

            $tel = str_replace($search, $replace, $telephone);

            $tiersFournisseur->setTelephone($tel);

            $tiersFournisseur->setSociete($soc);
            $tiersFournisseur->setCreated(new \DateTime());
            $tiersFournisseur->setCreatedBy($this->getUser()->getSlug());
            $tiersFournisseur->setEstSupprimer(0);

            $em->persist($tiersFournisseur);
            $em->flush();

            return $this->redirectToRoute('tiersfournisseur_show', array('id' => $tiersFournisseur->getId()));
        }

        return $this->render('tiersfournisseur/new.html.twig', array(
            'tiersFournisseur' => $tiersFournisseur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tiersFournisseur entity.
     *
     * @Route("/{id}", name="tiersfournisseur_show")
     * @Method("GET")
     */
    public function showAction(Request $request,TiersFournisseur $tiersFournisseur)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($tiersFournisseur);

        return $this->render('tiersfournisseur/show.html.twig', array(
            'tiersFournisseur' => $tiersFournisseur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tiersFournisseur entity.
     *
     * @Route("/{id}/edit", name="tiersfournisseur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TiersFournisseur $tiersFournisseur)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($tiersFournisseur);
        $editForm = $this->createForm('TiersBundle\Form\TiersFournisseurType', $tiersFournisseur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $fournisseur = $request->request->get('tiersbundle_tiersfournisseur');
            $telephone = $fournisseur['telephone'];

            $search = array('+', '(', ')', '.');

            $replace = array('', '', '', '');

            $tel = str_replace($search, $replace, $telephone);

            $tiersFournisseur->setTelephone($tel);

            $tiersFournisseur->setUpdateBy($this->getUser()->getSlug());
            $tiersFournisseur->setUpdateAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tiersfournisseur_show', array('id' => $tiersFournisseur->getId()));
        }

        return $this->render('tiersfournisseur/edit.html.twig', array(
            'tiersFournisseur' => $tiersFournisseur,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tiersFournisseur entity.
     *
     * @Route("/{id}", name="tiersfournisseur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TiersFournisseur $tiersFournisseur)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($tiersFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tiersFournisseur);
            $em->flush();
        }

        return $this->redirectToRoute('tiersfournisseur_index');
    }

    /**
     * Creates a form to delete a tiersFournisseur entity.
     *
     * @param TiersFournisseur $tiersFournisseur The tiersFournisseur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TiersFournisseur $tiersFournisseur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiersfournisseur_delete', array('id' => $tiersFournisseur->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Supprimer tiersFournisseur by setEstSupprimmer.
     *
     * @Route("/supprimmer/tiers/fournisseur/{id}", name="supprimmer_tiers_fournisseur")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(TiersFournisseur $tiersFournisseur, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $tiersFournisseur->setEstSupprimer(true);

        $tiersFournisseur->setUpdateBy($this->getUser()->getSlug());
        $tiersFournisseur->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('tiersfournisseur_index');
    }

}
