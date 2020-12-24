<?php

namespace ConfigBundle\Controller;

use ConfigBundle\Entity\ConfigTypeGenerationSociete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Configtypegenerationsociete controller.
 *
 * @Route("configtypegenerationsociete")
 */
class ConfigTypeGenerationSocieteController extends Controller
{
    /**
     * Lists all configTypeGenerationSociete entities.
     *
     * @Route("/", name="configtypegenerationsociete_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_FNS_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $configTypeGenerationSocietes = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findBy(['estSupprimer'=>0]);

        return $this->render('configtypegenerationsociete/index.html.twig', array(
            'configTypeGenerationSocietes' => $configTypeGenerationSocietes,
        ));
    }

    /**
     * Creates a new configTypeGenerationSociete entity.
     *
     * @Route("/new", name="configtypegenerationsociete_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_FNS_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $configTypeGenerationSociete = new Configtypegenerationsociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigTypeGenerationSocieteType', $configTypeGenerationSociete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $configTypeGenerationSociete->setCreated(new \DateTime());
            $configTypeGenerationSociete->setCreatedBy($this->getUser()->getSlug());
            $configTypeGenerationSociete->setSociete($this->getUser()->getAgence()->getSociete());
            $configTypeGenerationSociete->setEstSupprimer(0);

            $em->persist($configTypeGenerationSociete);
            $em->flush();

            return $this->redirectToRoute('configtypegenerationsociete_show', array('id' => $configTypeGenerationSociete->getId()));
        }

        return $this->render('configtypegenerationsociete/new.html.twig', array(
            'configTypeGenerationSociete' => $configTypeGenerationSociete,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a configTypeGenerationSociete entity.
     *
     * @Route("/{id}", name="configtypegenerationsociete_show")
     * @Method("GET")
     */
    public function showAction(Request $request,ConfigTypeGenerationSociete $configTypeGenerationSociete)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($configTypeGenerationSociete);

        return $this->render('configtypegenerationsociete/show.html.twig', array(
            'configTypeGenerationSociete' => $configTypeGenerationSociete,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing configTypeGenerationSociete entity.
     *
     * @Route("/{id}/edit", name="configtypegenerationsociete_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigTypeGenerationSociete $configTypeGenerationSociete)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($configTypeGenerationSociete);
        $editForm = $this->createForm('ConfigBundle\Form\ConfigTypeGenerationSocieteType', $configTypeGenerationSociete);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $configTypeGenerationSociete->setUpdateBy($this->getUser()->getSlug());
            $configTypeGenerationSociete->setUpdateAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('configtypegenerationsociete_edit', array('id' => $configTypeGenerationSociete->getId()));
        }

        return $this->render('configtypegenerationsociete/edit.html.twig', array(
            'configTypeGenerationSociete' => $configTypeGenerationSociete,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configTypeGenerationSociete entity.
     *
     * @Route("/{id}", name="configtypegenerationsociete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigTypeGenerationSociete $configTypeGenerationSociete)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $form = $this->createDeleteForm($configTypeGenerationSociete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configTypeGenerationSociete);
            $em->flush();
        }

        return $this->redirectToRoute('configtypegenerationsociete_index');
    }

    /**
     * Creates a form to delete a configTypeGenerationSociete entity.
     *
     * @param ConfigTypeGenerationSociete $configTypeGenerationSociete The configTypeGenerationSociete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigTypeGenerationSociete $configTypeGenerationSociete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configtypegenerationsociete_delete', array('id' => $configTypeGenerationSociete->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
