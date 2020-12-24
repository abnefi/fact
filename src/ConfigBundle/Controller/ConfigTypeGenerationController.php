<?php

namespace ConfigBundle\Controller;

use Cassandra\Date;
use ConfigBundle\Entity\ConfigTypeGeneration;
use ConfigBundle\Entity\ConfigTypeGenerationSociete;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Configtypegeneration controller.
 *
 * @Route("configtypegeneration")
 */
class ConfigTypeGenerationController extends Controller
{
    /**
     * Lists all configTypeGeneration entities.
     *
     * @Route("/", name="configtypegeneration_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['ROLE_ADMIN','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $soc = $this->getUser()->getAgence()->getSociete();

        $configTypeGenerationSociete = new Configtypegenerationsociete();
        $form = $this->createForm('ConfigBundle\Form\ConfigTypeGenerationSocieteType', $configTypeGenerationSociete);
        $form->handleRequest($request);
        
        $ltGenerations = $em->getRepository('ConfigBundle:ConfigTypeGeneration')->findBy(['estSupprimer' => 0, 'societe' => $soc]);
        $configTypeSoc = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findBy(['estSupprimer' => 0, 'societe' => $soc, 'estGenere' => 1], ['created' => 'DESC']);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $request->get('configType');
            $Conftype = $em->getRepository('ConfigBundle:ConfigTypeGeneration')->findOneBy(['estSupprimer' => 0, 'societe' => $soc, 'id' => $type]);

            if (($ltGenerations != null && $ltGenerations != '' && $ltGenerations != [] && count($ltGenerations) > 0))
            {
                if ($configTypeSoc != null && $configTypeSoc != '' && $configTypeSoc != [] && count($configTypeSoc) > 0)
                {
                    $dateUsed = $configTypeSoc[0]->getCreated();

                    $dateLimite = new \DateTime(($dateUsed)->format('Y') . '-12-31');
                    $datetypeCodeNow= new \DateTime();

                    if ($datetypeCodeNow < $dateLimite) {
                        $request->getSession()->getFlashBag()->add('avertir', 'Une Génération est déja activer, veuillez réesayer plus tard.');
                        return $this->redirectToRoute('configtypegeneration_index');
                    } else {
                        $configTypeGenerationSociete->setTypeGeneration($Conftype);
                        $configTypeGenerationSociete->setCreated(new \DateTime());
                        $configTypeGenerationSociete->setCreatedBy($this->getUser()->getSlug());
                        $configTypeGenerationSociete->setSociete($soc);
                        $configTypeGenerationSociete->setEstGenere(true);
                        $configTypeGenerationSociete->setEstSupprimer(0);

                        $em->persist($configTypeGenerationSociete);
                        $em->flush();

                        $request->getSession()->getFlashBag()->add('success', 'Validation réussie.');
                        return $this->redirectToRoute('configtypegeneration_index');

                    }

                }
                else {

                    $configTypeGenerationSociete->setTypeGeneration($Conftype);
                    $configTypeGenerationSociete->setCreated(new \DateTime());
                    $configTypeGenerationSociete->setCreatedBy($this->getUser()->getSlug());
                    $configTypeGenerationSociete->setSociete($soc);
                    $configTypeGenerationSociete->setEstGenere(true);
                    $configTypeGenerationSociete->setEstSupprimer(0);

                    $em->persist($configTypeGenerationSociete);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'Validation réussie.');
                    return $this->redirectToRoute('configtypegeneration_index');

                }
            }
        }

        return $this->render('configtypegeneration/index.html.twig', array(
            'configTypeGenerations' => $ltGenerations,
            'estGenererID' => $configTypeSoc ? $configTypeSoc[0]->getTypeGeneration()->getId() : 0,
            'form' => $form->createView(),

        ));
    }

    /**
     * Creates a new configTypeGeneration entity.
     *
     * @Route("/new", name="configtypegeneration_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $configTypeGeneration = new Configtypegeneration();
        $form = $this->createForm('ConfigBundle\Form\ConfigTypeGenerationType', $configTypeGeneration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $configTypeGeneration->setCreated(new \DateTime());
            $configTypeGeneration->setCreatedBy($this->getUser()->getSlug());
            $configTypeGeneration->setSociete($this->getUser()->getAgence()->getSociete());
            $configTypeGeneration->setEstSupprimer(0);
            $em->persist($configTypeGeneration);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Enregistrement effectué avec succès.');
            return $this->redirectToRoute('configtypegeneration_show', array('id' => $configTypeGeneration->getId()));
        }
        $codeSociete = $this->getUser()->getAgence()->getSociete()->getCode();

        return $this->render('configtypegeneration/new.html.twig', array(
            'configTypeGeneration' => $configTypeGeneration,
            'codeSociete' => $codeSociete,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a configTypeGeneration entity.
     *
     * @Route("/{id}", name="configtypegeneration_show")
     * @Method("GET")
     */
    public function showAction(Request $request,ConfigTypeGeneration $configTypeGeneration)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($configTypeGeneration);

        return $this->render('configtypegeneration/show.html.twig', array(
            'configTypeGeneration' => $configTypeGeneration,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing configTypeGeneration entity.
     *
     * @Route("/{id}/edit", name="configtypegeneration_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigTypeGeneration $configTypeGeneration)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($configTypeGeneration);
        $editForm = $this->createForm('ConfigBundle\Form\ConfigTypeGenerationType', $configTypeGeneration);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $configTypeGeneration->setUpdateBy($this->getUser()->getSlug());
            $configTypeGeneration->setUpdateAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'Modification effectué avec succès.');
            return $this->redirectToRoute('configtypegeneration_show', array('id' => $configTypeGeneration->getId()));
        }

        return $this->render('configtypegeneration/edit.html.twig', array(
            'configTypeGeneration' => $configTypeGeneration,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configTypeGeneration entity.
     *
     * @Route("/{id}", name="configtypegeneration_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigTypeGeneration $configTypeGeneration)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($configTypeGeneration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configTypeGeneration);
            $em->flush();
        }

        return $this->redirectToRoute('configtypegeneration_index');
    }

    /**
     * Creates a form to delete a configTypeGeneration entity.
     *
     * @param ConfigTypeGeneration $configTypeGeneration The configTypeGeneration entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigTypeGeneration $configTypeGeneration)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configtypegeneration_delete', array('id' => $configTypeGeneration->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Supprimer configTypeGeneration by setEstSupprimmer.
     *
     * @Route("/supprimmer/{id}", name="supprimmer_configTypeGeneration")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ConfigTypeGeneration $configTypeGeneration, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $configTypeGeneration->setEstSupprimer(true);

        $configTypeGeneration->setUpdateBy($this->getUser()->getSlug());
        $configTypeGeneration->setUpdateAt(new \DateTime());
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        return $this->redirectToRoute('configtypegeneration_index');
    }

}
