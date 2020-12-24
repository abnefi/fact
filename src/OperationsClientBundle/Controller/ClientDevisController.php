<?php

namespace OperationsClientBundle\Controller;

use ConfigBundle\Entity\ConfigTypeFacture;
use DateTime;
use OperationsClientBundle\Entity\ClientDevis;
use OperationsClientBundle\Entity\ClientFacture;
use OperationsClientBundle\Entity\ClientFactureDetail;
use OperationsClientBundle\Entity\ClientFactureVente;
use StockBundle\Entity\StockProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TiersBundle\Entity\TiersClient;
use UserBundle\Entity\FosUser;

/**
 * Clientdevi controller.
 *
 * @Route("clientdevis")
 */
class ClientDevisController extends DefaultController
{
    /**
     * Lists all clientDevi entities.
     *
     * @Route("/", name="clientdevis_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $clientDevis = $em->getRepository('OperationsClientBundle:ClientDevis')->findBy(['estSupprimer'=>0,'societe'=>$soc], ['id' => 'DESC']);
        $typesDevis = $em->getRepository('ConfigBundle:ConfigTypeFacture')
            ->findBy(['actif' => true, 'devis' => true,'estSupprimer'=>0]);

        return $this->render('clientdevis/index.html.twig', [
            'clientDevis' => $clientDevis,
            'typesDevis' => $typesDevis,
        ]);
    }

    /**
     * Creates a new clientDevi entity.
     *
     * @Route("/new", name="clientdevis_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $clientDevis = new ClientDevis();
        extract($this->getData($request, $clientDevis), EXTR_OVERWRITE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientDevis->setCreated(new \DateTime());
            $clientDevis->setCreatedBy($user->getSlug());
            $clientDevis->setSociete($societe);

            $em->persist($clientDevis);
            $details = $clientDevis->getDetails();
            foreach ($details as $detail) {
                $detail->setFacture($clientDevis);

                if (!$detail->getAibDeductible()) {
                    $detail->setAibDeductible(0)->setTauxAIB(0);
                }

                $detail->setCreated(new DateTime());
                $detail->setCreatedBy($this->getUser()->getSlug());
                $detail->setEstSupprimer(0);
            }
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Création effectuée avec succès');
            return $this->redirectToRoute('clientdevis_show', array('id' => $clientDevis->getId()));
        }

        return $this->render('clientdevis/new.html.twig', $data);
    }


    /**
     * Finds and displays a clientDevi entity.
     *
     * @Route("/{id}", name="clientdevis_show")
     * @Method("GET")
     */
    public function showAction(Request $request,ClientDevis $clientDevis)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $deleteForm = $this->createDeleteForm($clientDevis);
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $factureVente = null; //On suppose qu'aucune facture de vente n'a été générée à partir de ce devis
        if ($clientDevis->getEstValide()) {
            $factureVente = $em->getRepository('OperationsClientBundle:ClientFactureVente')
                ->findOneBy(['reference' => $clientDevis->getReferenceFactureVenteGenere(),'estSupprimer'=>0,'societe'=>$soc]);
        }

        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientDevis);
        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientDevis);
        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientDevis);
        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientDevis);
        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientDevis);
        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientDevis);

        return $this->render('clientdevis/show.html.twig', array(
            'clientFacture' => $clientDevis,
            'factureVente' => $factureVente,
            'montantTotalHT' => $totalHT,
            'montantTotalTVA' => $totalTVA,
            'montantTotalAIB' => $totalAIB,
            'totalTaxeSpecifique' => $totalTaxeSpecifique,
            'montantTotalTTC' => $totalTTC,
            'montantTotalAPayer' => $totalAPayer,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing clientDevi entity.
     *
     * @Route("/{id}/edit", name="clientdevis_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ClientDevis $clientDevis)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        extract($this->getData($request, $clientDevis, true), EXTR_OVERWRITE);
        $deleteForm = $this->createDeleteForm($clientDevis);

        $donnees = $request->request->get('operationsclientbundle_clientdevis');
        $donnees['client'] = $client->getId();
        $request->request->set('operationsclientbundle_clientdevis', $donnees);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($clientDevis); die();
            $details = $clientDevis->getDetails();
            /** @var ClientFactureDetail $detail */
            foreach ($details as $detail) {
                $detail->setFacture($clientDevis);

                $detail->setUpdateBy($this->getUser()->getSlug());
                $detail->setUpdatedAt(new \DateTime());
                $detail->setEstSupprimer(0);

                if (!$detail->getAibDeductible()) {
                    $detail->setAibDeductible(0)->setTauxAIB(0);
                }

                if (trim($detail->getCreatedBy()) == '') {
                    $detail->setCreatedBy($this->getUser()->getSlug());
                    $detail->setCreated(new DateTime());
                }
            }
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Modification effectuée avec succès');
            return $this->redirectToRoute('clientdevis_show', array('id' => $clientDevis->getId()));
        }

        $donnees['delete_form'] = $deleteForm->createView();

        return $this->render('clientdevis/new.html.twig', $data);
    }

    /**
     *
     * @Route("/{id}/print", options={"expose"=true},  name="clientdevis_print")
     * @Method({"GET", "POST"})
     */
    public function printAction(Request $request, ClientDevis $clientDevis)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $pdfInfo = $this->get('app.facture')->generate(
            $this->getUser(),
            $clientDevis,
            false,
            'DEVIS',
            true,
            $this->getParameter('repertoire_upload')
        );

        $url = $request->getScheme() . '://' . $request->getHttpHost() .
            $request->getBasePath() . '/uploads/tmp/' . $pdfInfo->fileName;

        return new JsonResponse([
            'url' => $url,
            'filePath' => $pdfInfo->filePath
        ]);
    }

    /**
     * Creates a new clientFacture entity.
     *
     * @Route("/{id}/new/facture/vente", name="clientdevis_new_facture_vente")
     * @Method({"GET", "POST"})
     */
    public function creerFactureVenteAction(Request $request, ClientDevis $clientDevis)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $clientFactureVente = new ClientFactureVente();
        $user = $this->getUser();
        $societe = $user->getAgence()->getSociete();

        $configTypeFacture = $em->getRepository('ConfigBundle:ConfigTypeFacture')->findOneBy(['code' => 'FV','estSupprimer'=>0]);
        $clientFactureVente->setTypeFacture($configTypeFacture);

        //Création de la référence
        $reference = $this->get('code_generate')->genererReferenceFacture($clientFactureVente->getTypeFacture(),$societe->getId());
        $clientFactureVente->setReference($reference);
        $em = $this->getDoctrine()->getManager();

        if ($societe->getAssujetiTva() == true) {
            $tauxTVA = $em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'tva','estSupprimer'=>0]);
            $clientFactureVente->setTauxTVA($tauxTVA->getValeurTaux());
        }
        $clientFactureVente->setAgence($user->getAgence());
        $clientFactureVente->setDevise($clientDevis->getDevise());
        $clientFactureVente->setTauxTVA($clientDevis->getTauxTVA());
//        $clientFactureVente->setTauxAIB($clientDevis->getTauxAIB());
        $clientFactureVente->setTauxChange($clientDevis->getTauxChange());
        $clientFactureVente->setClient($clientDevis->getClient());
        $clientFactureVente->setApplicationAIB($clientDevis->getApplicationAIB());
        $clientFactureVente->setDateFacture($clientDevis->getDateFacture());
        $clientFactureVente->setDateReglement($clientDevis->getDateFacture());
        $clientFactureVente->setNotes($clientDevis->getNotes());
        $detailsDevis = $clientDevis->getDetails();

//        $arrayDetails = [];
        /** @var ClientFactureDetail $detailDevis */
        foreach ($detailsDevis as $detailDevis) {
            $detail = new ClientFactureDetail();
            /*$detail->setFacture($clientFactureVente);
            $detail->setTauxRemise($detailDevis->getTauxRemise());
            $detail->setChangementPrixUnitaireTTC($detailDevis->getChangementPrixUnitaireTTC());
            $detail->setDernierPrixOrigine($detailDevis->getDernierPrixOrigine());
            $detail->setDescription($detailDevis->getDescription());
            $detail->setPrixVenteUnitaire($detailDevis->getPrixVenteUnitaire());
            $detail->setProduit($detailDevis->getProduit());
            $detail->setTaxeSpecifique($detailDevis->getTaxeSpecifique());
            $detail->setHasTaxeSpecifique($detailDevis->getHasTaxeSpecifique());
            $detail->setTaxeDeSejour($detailDevis->getTaxeDeSejour());
            $detail->setQuantite($detailDevis->getQuantite());
            $detail->setUniteMesure($detailDevis->getUniteMesure());
            $detail->setUpdatedAt(new \DateTime());*/
            $detail->setQuantite($detailDevis->getQuantite());
            $detail->setPrixVenteUnitaire($detailDevis->getPrixVenteUnitaire());
            $detail->setTauxRemise($detailDevis->getTauxRemise());
            $detail->setDescription($detailDevis->getDescription());
            $detail->setChangementPrixUnitaireTTC($detailDevis->getChangementPrixUnitaireTTC());
            $detail->setDernierPrixOrigine($detailDevis->getDernierPrixOrigine());
            $detail->setDescriptionPrixOrigine($detailDevis->getDescriptionPrixOrigine());
            $detail->setUpdatedAt($detailDevis->getUpdatedAt());
            $detail->setFacture($detailDevis->getFacture());
            $detail->setProduit($detailDevis->getProduit());
            $detail->setUniteMesure($detailDevis->getUniteMesure());
            $detail->setCreated($detailDevis->getCreated());
            $detail->setEstSupprimer(0);
            $detail->setAibDeductible($detailDevis->getAibDeductible());
            $detail->setTauxAIB($detailDevis->getTauxAIB());
            $detail->setHasTaxeSpecifique($detailDevis->getHasTaxeSpecifique());
            $detail->setTaxeSpecifique($detailDevis->getTaxeSpecifique());
            $detail->setDescriptionTaxeSpecifique($detailDevis->getDescriptionTaxeSpecifique());
            $detail->setTaxeDeSejour($detailDevis->getTaxeDeSejour());

            $clientFactureVente->addDetail($detail);
//            $arrayDetails[] = $detail;
        }
        $clientFactureVente->setEstCreeParDevis(true);
        $form = $this->createForm('OperationsClientBundle\Form\ClientFactureVenteType', $clientFactureVente, [
            'entity_manager' => $em, 'type_activite' => $societe->getTypeActivite()->getCode()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $clientFactureVente->setCreated(new \DateTime());
            $clientFactureVente->setCreatedBy($this->getUser()->getSlug());

            $clientFactureVente->setUser($user);
            $em->persist($clientFactureVente);
            $details = $clientFactureVente->getDetails();

            foreach ($details as $detail) {
                $detail->setFacture($clientFactureVente);
                $detail->setUpdateBy($this->getUser()->getSlug());
                $detail->setUpdateAt(new \DateTime());
            }
            $clientDevis->setReferenceFactureVenteGenere($clientFactureVente->getReference());
            $clientDevis->setEstValide(true);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Création effectuée avec succès');
            return $this->redirectToRoute('clientdevis_show', array('id' => $clientFactureVente->getId()));
        }

        $json = [
            'stock' => $em->getRepository(StockProduit::class)->listProduit($societe),
            'clients' => $em->getRepository(TiersClient::class)->listClient($societe),
            'assujetiTva' => $societe->getAssujetiTva(),
            'liberal' => $societe->getEstProfessionLiberale(),
            'devise' => $societe->getDevise()->getId(),
            'roundPrice' => $this->getParameter('arrondir_au_franc'),
            'edit' => $em->getRepository(ClientFacture::class)->getEditInfo($clientDevis)
        ];


        return $this->render('clientfacturevente/new.html.twig', array(
            'clientFacture' => $clientFactureVente,
            'form' => $form->createView(),
            'json' => json_encode($json)
        ));
    }

    /**
     * Deletes a clientDevi entity.
     *
     * @Route("/{id}", name="clientdevis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ClientDevis $clientDevi)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($clientDevi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clientDevi);
            $em->flush();
        }

        return $this->redirectToRoute('clientdevis_index');
    }

    /**
     * Creates a form to delete a clientDevi entity.
     *
     * @param ClientDevis $clientDevi The clientDevi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ClientDevis $clientDevi)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientdevis_delete', array('id' => $clientDevi->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Supprimer ClientDevis by setEstSupprimmer.
     *
     * @Route("/supprimmer/client/devis/{id}", name="supprimmer_client_devis")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ClientDevis $clientDevi, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $clientDevi->setEstSupprimer(true);

        $clientDevi->setUpdateBy($this->getUser()->getSlug());
        $clientDevi->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        return $this->redirectToRoute('clientdevis_index');

    }

}
