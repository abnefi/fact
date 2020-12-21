<?php

namespace OperationsClientBundle\Controller;

use ConfigBundle\Entity\ConfigTypeFacture;
use OperationsClientBundle\Entity\ClientFacture;
use OperationsClientBundle\Entity\ClientFactureAvoir;
use OperationsClientBundle\Entity\ClientFactureDetail;
use OperationsClientBundle\Entity\ClientFactureVente;
use OperationsClientBundle\Entity\ClientPaiement;
use Proxies\__CG__\ConfigBundle\Entity\ConfigSociete;
use StockBundle\Entity\StockArticle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Entity\FosUser;
use UserBundle\Entity\UserSociete;

/**
 * Clientfacture controller.
 *
 * @Route("clientfacture")
 */
class ClientFactureController extends Controller
{
    /**
     * Lists all clientFacture entities.editPaiementAction
     *
     * @Route("/", name="clientfacture_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $societe = $user->getAgence()->getSociete();

        $codesFactures = ['FV', 'EV', 'FA', 'EA'];
        $clientFactures = $em->getRepository('OperationsClientBundle:ClientFacture')
            ->getFacturesAvoirEtVente($codesFactures,$societe);
        $typesFactures = $em->getRepository('ConfigBundle:ConfigTypeFacture')
            ->findBy(['actif' => true, 'devis' => false, 'export' => false,'estSupprimer'=>0]);

        $facturesAvoir = $em->getRepository('OperationsClientBundle:ClientFactureAvoir')->findBy(['estSupprimer'=>0,'societe'=>$societe]);
        $referencesOriginesFacturesAvoir = [];
        foreach ($facturesAvoir as $factureAvoir) {
            $referencesOriginesFacturesAvoir[] = $factureAvoir->getReferenceFactureOrigine();
        }
        $facturesVente_SansAvoirs = $em->getRepository('OperationsClientBundle:ClientFactureVente')
            ->findBy(['estValide' => true, 'hasAvoir' => false,'estSupprimer'=>0,'societe'=>$societe]);

        $clients = $em->getRepository('TiersBundle:TiersClient')->findBy(['societe' => $societe,'estSupprimer'=>0,'societe'=>$societe]);

        $configEtat = $em->getRepository('ConfigBundle:ConfigEtat')->findBy(['estSupprimer' => 0]);
//        dump($configEtat);die();
        $data = [
            'clientFactures'           => $clientFactures,
            'typesFactures'            => $typesFactures,
            'facturesVente_SansAvoirs' => $facturesVente_SansAvoirs,
            'clients'                  => $clients,
            'etats'                     => $configEtat,
        ];
        return $this->render('clientfacture/index.html.twig', $data);
    }

    /**
     * Displays a form to edit an existing clientPaiement entity.
     *
     * @Route("/{id}/valider", name="clientfacture_valider")
     * @Method({"GET", "POST"})
     */
    public function validerAction(Request $request, ClientFacture $clientFacture)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $details = $clientFacture->getDetails();

        foreach ($details as $detail) {
            $produit = $detail->getProduit();
            if ($produit instanceof StockArticle) {
                if ($clientFacture->getTypeFacture()->getAvoir() == false) {
                    $newStockDispo = $produit->getStockDisponible() - $detail->getQuantite();
                } else {
                    $newStockDispo = $produit->getStockDisponible() + $detail->getQuantite();
                }
                $produit->setStockDisponible($newStockDispo);

                $produit->setCreated(new \DateTime());
                $produit->setCreatedBy($this->getUser()->getSlug());
                $produit->setEstSupprimer(0);

                $em->persist($produit);
            }
        }
        $clientFacture->setEstValide(true);
        $etatEnAttente = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'EA','estSupprimer'=>0]);
        $clientFacture->setEtatDeclaration($etatEnAttente);

        $clientFacture->setUpdateBy($this->getUser()->getSlug());
        $clientFacture->setUpdatedAt(new \DateTime());

        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Validation effectuée avec succès');
        switch ($clientFacture->getTypeFacture()->getCode()) {
            case 'FV':
                return $this->redirectToRoute('clientfacturevente_show', array('id' => $clientFacture->getId()));
                break;

            case 'FA':
                return $this->redirectToRoute('clientfactureavoir_show', array('id' => $clientFacture->getId()));
                break;
        }
        return $this->redirectToRoute('clientfacture_index');
    }

    /**
     * Displays a form to edit an existing clientPaiement entity.
     *
     * @Route("/{id}/paiement", name="clientfacture_paiement")
     * @Method({"GET", "POST"})
     */
    public function paiementAction(Request $request, ClientFacture $clientFacture)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $paiements = $em->getRepository('OperationsClientBundle:ClientPaiement')
            ->findBy(['facture' => $clientFacture,'supprimer'=>0]);
        $montantTotalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFacture);
        $montantDejaPaye = $this->get('client_operations')->calculerMontantDejaPaye($clientFacture);
        $montantRestantAPayer = $montantTotalAPayer - $montantDejaPaye;
        return $this->render('clientfacture/paiement/index.html.twig', array(
            'clientFacture' => $clientFacture,
            'paiements' => $paiements,
            'montantTotalAPayer' => $montantTotalAPayer,
            'montantDejaPaye' => $montantDejaPaye,
            'montantRestantAPayer' => $montantRestantAPayer,
        ));
    }

    /**
     * Displays a form to edit an existing clientPaiement entity.
     *
     * @Route("/{id}/edit/paiement", name="clientfacture_editpaiement")
     * @Method({"GET", "POST"})
     */
    public function editPaiementAction(Request $request, ClientFacture $clientFacture)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $paiementsForm = $this->createForm('OperationsClientBundle\Form\ClientFacturePaiementType', $clientFacture);
        $paiementsForm->handleRequest($request);

        if ($paiementsForm->isSubmitted() && $paiementsForm->isValid()) {
            $facturePaiements = $clientFacture->getPaiements();
            foreach ($facturePaiements as $paiement) {
                $paiement->setFacture($clientFacture);

                $paiement->setUpdateBy($this->getUser()->getSlug());
                $paiement->setCreatedBy($this->getUser()->getSlug());
//                $paiement->setUpdateAt(new \DateTime());
            }
            $request->getSession()->getFlashBag()->add('success', 'Enregistrement effectué avec succès');
            $montantTotalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFacture);
            $montantDejaPaye = $this->get('client_operations')->calculerMontantDejaPaye($clientFacture);
            $montantRestantAPayer = $montantTotalAPayer - $montantDejaPaye;
            if (round($montantRestantAPayer) == 0) {
                $clientFacture->setEstPayee(true);
                $request->getSession()->getFlashBag()->add('success', 'La facture a été marquée comme payée car il ne reste plus rien à payer.');
            }

            $clientFacture->setUpdateBy($this->getUser()->getSlug());
//            $clientFacture->setUpdateAt(new \DateTime());

            $em->flush();
            return $this->redirectToRoute('clientfacture_paiement', array('id' => $clientFacture->getId()));
        }
        $paiements = $em->getRepository('OperationsClientBundle:ClientPaiement')
            ->findBy(['facture' => $clientFacture,'supprimer'=>0]);
        $montantTotalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFacture);
        $montantDejaPaye = $this->get('client_operations')->calculerMontantDejaPaye($clientFacture);
        $montantRestantAPayer = $montantTotalAPayer - $montantDejaPaye;
        return $this->render('clientfacture/paiement/edit.html.twig', [
            'clientFacture' => $clientFacture,
            'form' => $paiementsForm->createView(),
            'paiements' => $paiements,
            'montantTotalAPayer' => $montantTotalAPayer,
            'montantDejaPaye' => $montantDejaPaye,
            'montantRestantAPayer' => $montantRestantAPayer,
        ]);
    }

    /**
     * Creates a new clientPaiement entity.
     *
     * @Route("{id}/new/paiement", options={"expose"=true}, name="clientfacture_newpaiement_form")
     * @Method({"GET", "POST"})
     */
    public function newPaiementFormAction(Request $request, ClientFacture $clientFacture)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $clientPaiement = new ClientPaiement();
        $clientPaiement->setFacture($clientFacture);
        $em = $this->getDoctrine()->getManager();
        $modePaiement = $em->getRepository('ConfigBundle:ConfigModePaiement')->findOneBy(['code' => 'E','estSupprimer'=>0]);
        $clientPaiement->setModePaiement($modePaiement);
        $form = $this->createForm('OperationsClientBundle\Form\ClientPaiementType', $clientPaiement);
        $form->handleRequest($request);
        if ($request->isMethod('Post')) {
            if ($form->isSubmitted() && $form->isValid()) {

                $clientPaiement->setCreated(new \DateTime());
                $clientPaiement->setCreatedBy($this->getUser()->getSlug());
                $clientPaiement->setEstSupprimer(0);

                $em->persist($clientPaiement);
                $em->flush();

                return $this->redirectToRoute('clientpaiement_show', array('id' => $clientPaiement->getId()));
            }
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('clientfacture/paiement/new.html.twig', array(
                'clientPaiement' => $clientPaiement,
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * Finds and displays a clientFacture entity.
     *
     * @Route("/{id}/declarer", name="clientfacture_declarer")
     * @Method("GET")
     */
    public function declarerAction(Request $request, ClientFacture $clientFacture)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $agence = $user->getAgence();
        if (null === $agence) {
            throw new NotFoundHttpException("Cet utilisateur n'est lié à aucune société.");
        }
        $societe = $agence->getSociete();

        $etatEnAttente = $em->getRepository('ConfigBundle:ConfigEtat')->findOneBy(['code' => 'EA','estSupprimer'=>0]);
        $clientFacture->setEtatDeclaration($etatEnAttente);

        $clientFacture->setUpdateBy($this->getUser()->getSlug());
        $clientFacture->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'La facture est désormais en attente de déclaration.');
        switch ($clientFacture->getTypeFacture()->getCode()) {
            case 'FV':
                return $this->redirectToRoute('clientfacturevente_show', array('id' => $clientFacture->getId()));
                break;

            case 'FA':
                return $this->redirectToRoute('clientfactureavoir_show', array('id' => $clientFacture->getId()));
                break;
        }
        return $this->redirectToRoute('clientfacture_index');
    }

    /**
     * Deletes a clientFacture entity.
     *
     * @Route("/{id}", name="clientfacture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ClientFacture $clientFacture)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($clientFacture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clientFacture);
            $em->flush();
        }

        return $this->redirectToRoute('clientfacture_index');
    }

    /**
     * Creates a form to delete a clientFacture entity.
     *
     * @param ClientFacture $clientFacture The clientFacture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ClientFacture $clientFacture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientfacture_delete', array('id' => $clientFacture->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}