<?php

namespace ConfigBundle\Controller;

use ConfigBundle\Entity\ConfigPaysLang;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Configpay controller.
 *
 * @Route("configpays")
 */
class ConfigPaysController extends Controller
{
    /**
     * Lists all configPay entities.
     *
     * @Route("/", name="configpays_index")
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

        $configPays = $em->getRepository('ConfigBundle:ConfigPaysLang')->findBy(array('lang'=>1,'estSupprimer' => false));
        return $this->render('configpays/index.html.twig', array(
            'configPays' => $configPays,
        ));
    }

    /**
     * Creates a new configPay entity.
     *
     * @Route("/new", name="configpays_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $configPay = new ConfigPaysLang();
        $form = $this->createForm('ConfigBundle\Form\ConfigPaysType', $configPay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $configPay->setCreated(new \DateTime());
            $configPay->setCreatedBy($this->getUser()->getSlug());
            $configPay->setEstSupprimer(0);

            $em->persist($configPay);
            $em->flush();

            return $this->redirectToRoute('configpays_show', array('id' => $configPay->getId()));
        }

        return $this->render('configpays/new.html.twig', array(
            'configPay' => $configPay,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a configPay entity.
     *
     * @Route("/{id}", name="configpays_show")
     * @Method("GET")
     */
    public function showAction(Request $request,ConfigPaysLang $configPay)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($configPay);

        return $this->render('configpays/show.html.twig', array(
            'configPay' => $configPay,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Supprimer configPay by setEstSupprimmer.
     *
     * @Route("/supprimmer/{id}", name="supprimmer_configpays")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ConfigPaysLang $configPay, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $configPay->setEstSupprimer(true);

        $configPay->setUpdateBy($this->getUser()->getSlug());
        $configPay->setUpdateAt(new \DateTime());
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        return $this->redirectToRoute('configpays_index');
    }

    /**
     * Displays a form to edit an existing configPay entity.
     *
     * @Route("/{id}/edit", name="configpays_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigPaysLang $configPay)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($configPay);
        $editForm = $this->createForm('ConfigBundle\Form\ConfigPaysType', $configPay->getPays());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $configPay->setUpdateBy($this->getUser()->getSlug());
            $configPay->setUpdateAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'Modification réussie.');
            return $this->redirectToRoute('configpays_index');
        }

        return $this->render('configpays/edit.html.twig', array(
            'configPay' => $configPay,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configPay entity.
     *
     * @Route("/{id}", name="configpays_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigPaysLang $configPay)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($configPay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configPay);
            $em->flush();
        }

        return $this->redirectToRoute('configpays_index');
    }

    /**
     * Creates a form to delete a configPay entity.
     *
     * @param ConfigPaysLang $configPay The configPay entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigPaysLang $configPay)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configpays_delete', array('id' => $configPay->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
