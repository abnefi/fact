<?php

namespace TiersBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Session\Session;
use TiersBundle\Entity\TiersClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tiersclient controller.
 *
 * @Route("tiersclient")
 */
class TiersClientController extends Controller
{
    /**
     * Lists all tiersClient entities.
     *
     * @Route("/", name="tiersclient_index")
     * @Method("GET")
     */

    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $tiersClients = $em->getRepository('TiersBundle:TiersClient')->findBy(['estSupprimer'=>0,'societe'=>$soc],['created'=>'DESC']);

        return $this->render('tiersclient/index.html.twig', array(
            'tiersClients' => $tiersClients,
        ));
    }

    /**
     * Creates a new tiersClient entity.
     *
     * @Route("/new", name="tiersclient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $tiersClient = new Tiersclient();
        $soc = $this->getUser()->getAgence()->getSociete();

        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')
            ->findBy(['societe' => $soc,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            $code = $this->get('code_generate')->genererCodeClient($soc->getId());
            $tiersClient->setCode($code);
        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');

        }


        $form = $this->createForm('TiersBundle\Form\TiersClientType', $tiersClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $client = $request->request->get('tiersbundle_tiersclient');
            $telephone = $client['telephone'];

            $search = array('+', '(', ')', '.');

            $replace = array('', '', '', '');

            $tel = str_replace($search, $replace, $telephone);

            $tiersClient->setTelephone($tel);

            $tiersClient->setSociete($soc);
            $tiersClient->setCreated(new \DateTime());
            $tiersClient->setCreatedBy($this->getUser()->getSlug());
            $tiersClient->setEstSupprimer(0);

            $em->persist($tiersClient);
            $em->flush();

            return $this->redirectToRoute('tiersclient_show', array('id' => $tiersClient->getId()));
        }

        return $this->render('tiersclient/new.html.twig', array(
            'tiersClient' => $tiersClient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tiersClient entity.
     *
     * @Route("/{id}", name="tiersclient_show")
     * @Method("GET")
     */
    public function showAction(Request $request,TiersClient $tiersClient)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($tiersClient);

        return $this->render('tiersclient/show.html.twig', array(
            'tiersClient' => $tiersClient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tiersClient entity.
     *
     * @Route("/{id}/edit", name="tiersclient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TiersClient $tiersClient)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($tiersClient);
        $editForm = $this->createForm('TiersBundle\Form\TiersClientType', $tiersClient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $client = $request->request->get('tiersbundle_tiersclient');
            $telephone = $client['telephone'];

            $search = array('+', '(', ')', '.');

            $replace = array('', '', '', '');

            $tel = str_replace($search, $replace, $telephone);

            $tiersClient->setTelephone($tel);

            $tiersClient->setUpdateBy($this->getUser()->getSlug());
            $tiersClient->setUpdateAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tiersclient_show', array('id' => $tiersClient->getId()));
        }

        return $this->render('tiersclient/edit.html.twig', array(
            'tiersClient' => $tiersClient,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tiersClient entity.
     *
     * @Route("/{id}", name="tiersclient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TiersClient $tiersClient)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($tiersClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tiersClient);
            $em->flush();
        }

        return $this->redirectToRoute('tiersclient_index');
    }

    /**
     * Creates a form to delete a tiersClient entity.
     *
     * @param TiersClient $tiersClient The tiersClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TiersClient $tiersClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiersclient_delete', array('id' => $tiersClient->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Supprimer tiersClient by setEstSupprimmer.
     *
     * @Route("/supprimmer/tiers/client/{id}", name="supprimmer_tiers_client")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(TiersClient $tiersClient, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN','ROLE_CONTROLEUR','ROLE_COMPTABLE','ROLE_CAISSE','ROLE_AGENT','ROLE_VENDEUR'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $tiersClient->setEstSupprimer(true);

        $tiersClient->setUpdateBy($this->getUser()->getSlug());
        $tiersClient->setUpdateAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');

        return $this->redirectToRoute('tiersclient_index');
    }


}
