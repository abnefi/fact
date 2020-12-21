<?php

namespace OperationsClientBundle\Controller;

use OperationsClientBundle\Entity\ClientFactureAvoir;
use OperationsClientBundle\Entity\ClientFactureDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\FosUser;

/**
 * Clientfactureavoir controller.
 *
 * @Route("clientfactureavoir")
 */
class ClientFactureAvoirController extends Controller
{

    /**
     * Creates a new clientFacture avoir entity.
     *
     * @Route("/new/{idFactureOrigine}", name="clientfactureavoir_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param         $idFactureOrigine
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, $idFactureOrigine)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $clientFacture = new ClientFactureAvoir();

        $em = $this->getDoctrine()->getManager();
//        $configTypeFacture = $em->getRepository('ConfigBundle:ConfigTypeFacture')->find($idTypeFacture);
        $configTypeFacture = $em->getRepository('ConfigBundle:ConfigTypeFacture')->findOneBy(['code' => 'FA']);
        $factureOrigine = $em->getRepository('OperationsClientBundle:ClientFactureVente')->find($idFactureOrigine);
        $clientFacture->setTypeFacture($configTypeFacture);
        $clientFacture->setReferenceFactureOrigine($factureOrigine->getReference());
        //Création de la référence
        $reference = $this->get('code_generate')->genererReferenceFacture($clientFacture->getTypeFacture(),$this->getUser()->getAgence()->getSociete()->getId());
        $clientFacture->setReference($reference);
        $user = $this->getUser();
        $clientFacture->setClient($factureOrigine->getClient());
        $clientFacture->setSociete($factureOrigine->getSociete());
//        $clientFacture->setTauxAIB($factureOrigine->getTauxAIB());
        $clientFacture->setTauxTVA($factureOrigine->getTauxTVA());
        $clientFacture->setDevise($factureOrigine->getDevise());
        $clientFacture->setTotalTTC($factureOrigine->getTotalTTC());
        $clientFacture->setTotalAIB($factureOrigine->getTotalAIB());
        $clientFacture->setTotalTVA($factureOrigine->getTotalTVA());
        $clientFacture->setTotalHT($factureOrigine->getTotalHT());
        $clientFacture->setEstSupprimer(0);
        $detailsOrigine = $factureOrigine->getDetails();


        $mesId = array();

        foreach ($detailsOrigine as $details)
        {
            $mesId[]=$details->getId();
        }

        $mesId=json_encode($mesId);

        $form = $this->createForm('OperationsClientBundle\Form\ClientFactureAvoirType', $clientFacture, [
            'entity_manager' => $em, 'type_activite' => $user->getAgence()->getSociete()->getTypeActivite()->getCode()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Liste_mesId = $request->get('mesId');
            $Liste_mesId =json_decode($Liste_mesId, false);

//            foreach ($clientFacture->getDetails() as &$detail) {
//                foreach ($factureOrigine as $origine) {
//                    if ($detail->getProduit()->getId() === $origine->getProduit()->getId()) {
//                        $detail->setAibDeductible($origine->getAibDeductible());
//                    }
//                }
//            }
//            unset($detail);

            $clientFacture->setAgence($user->getAgence());
            $clientFacture->setUser($user);
            $clientFacture->setCreatedBy($this->getUser()->getSlug());
            $em->persist($clientFacture);

            foreach ($detailsOrigine as $detailOrigine)
            {
                foreach ($Liste_mesId as $list)
                {
                    if ($detailOrigine->getId() == $list)
                    {

                        $quantite = $request->get('quantite_detail_'.$list);
                        $remise = $request->get('remise_detail_'.$list);

                        $detailAvoir = new ClientFactureDetail();

                        $detailAvoir->setQuantite($quantite);
                        $detailAvoir->setTauxRemise($remise);
                        $detailAvoir->setFacture($clientFacture);
                        $detailAvoir->setChangementPrixUnitaireTTC($detailOrigine->getChangementPrixUnitaireTTC());
                        $detailAvoir->setDernierPrixOrigine($detailOrigine->getDernierPrixOrigine());
                        $detailAvoir->setDescription($detailOrigine->getDescription());
                        $detailAvoir->setPrixVenteUnitaire($detailOrigine->getPrixVenteUnitaire());
                        $detailAvoir->setProduit($detailOrigine->getProduit());
                        $detailAvoir->setUniteMesure($detailOrigine->getUniteMesure());
                        $detailAvoir->setEstSupprimer(0);
                        $detailAvoir->setAibDeductible($detailOrigine->getAibDeductible());
                        $detailAvoir->setHasTaxeSpecifique($detailOrigine->getHasTaxeSpecifique());
                        $detailAvoir->setTaxeSpecifique($detailOrigine->getTaxeSpecifique());

                        $detailAvoir->setCreated(new \DateTime());
                        $detailAvoir->setCreatedBy($this->getUser()->getSlug());

                        $em->persist($detailAvoir);
                    }

                }

            }
            $factureOrigine->setHasAvoir(true);

            $factureOrigine->setCreated(new \DateTime());
            $factureOrigine->setCreatedBy($this->getUser()->getSlug());
            $factureOrigine->setEstSupprimer(0);

            $em->persist($factureOrigine);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Création effectuée avec succès');
            return $this->redirectToRoute('clientfactureavoir_show', array('id' => $clientFacture->getId()));
        }

        return $this->render('clientfactureavoir/new.html.twig', array(
            'clientFacture' => $clientFacture,
            'factureOrigine' => $factureOrigine,
            'mesId'=>$mesId,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a clientFactureAvoir entity.
     *
     * @Route("/{id}", name="clientfactureavoir_show")
     * @Method("GET")
     * @param Request            $request
     * @param ClientFactureAvoir $clientFactureAvoir
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request,ClientFactureAvoir $clientFactureAvoir)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($clientFactureAvoir);
        $em = $this->getDoctrine()->getManager();
        $soc = $this->getUser()->getAgence()->getSociete();

        $factureOrigine = $em->getRepository('OperationsClientBundle:ClientFactureVente')
            ->findOneBy(['reference' => $clientFactureAvoir->getReferenceFactureOrigine(),'societe'=>$soc]);

        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientFactureAvoir);
        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientFactureAvoir);
        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientFactureAvoir);
        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientFactureAvoir);
        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientFactureAvoir);
        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFactureAvoir);

        return $this->render('clientfactureavoir/show.html.twig', array(
            'clientFacture' => $clientFactureAvoir,
            'factureOrigine' => $factureOrigine,
            'delete_form' => $deleteForm->createView(),
            'montantTotalHT' => $totalHT,
            'montantTotalTVA' => $totalTVA,
            'montantTotalAIB' => $totalAIB,
            'totalTaxeSpecifique' => $totalTaxeSpecifique,
            'montantTotalTTC' => $totalTTC,
            'montantTotalAPayer' => $totalAPayer,
        ));
    }

    /**
     * Displays a form to edit an existing clientFactureAvoir entity.
     *
     * @Route("/{id}/edit", name="clientfactureavoir_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ClientFactureAvoir $clientFactureAvoir)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($clientFactureAvoir);
        $user = $this->getUser();
        $soc = $user->getAgence()->getSociete();

        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createForm('OperationsClientBundle\Form\ClientFactureAvoirType', $clientFactureAvoir, [
            'entity_manager' => $em, 'type_activite' => $user->getAgence()->getSociete()->getTypeActivite()->getCode()
        ]);
        $editForm->handleRequest($request);

        $factureOrigine = $em->getRepository('OperationsClientBundle:ClientFactureVente')
            ->findOneBy(['reference' => $clientFactureAvoir->getReferenceFactureOrigine(),'estSupprimer'=>0,'societe'=>$soc]);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $clientFactureAvoir->setUpdateBy($this->getUser()->getSlug());
            $clientFactureAvoir->setUpdateAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'Modification effectuée avec succès');
            return $this->redirectToRoute('clientfactureavoir_show', array('id' => $clientFactureAvoir->getId()));
        }

        return $this->render('clientfactureavoir/edit.html.twig', array(
            'clientFacture' => $clientFactureAvoir,
            'factureOrigine' => $factureOrigine,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a clientFactureAvoir entity.
     *
     * @Route("/{id}", name="clientfactureavoir_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ClientFactureAvoir $clientFactureAvoir)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($clientFactureAvoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clientFactureAvoir);
            $em->flush();
        }

        return $this->redirectToRoute('clientfactureavoir_index');
    }

    /**
     *
     * @Route("/{id}/print", options={"expose"=true},  name="clientfactureavoir_print")
     * @Method({"GET", "POST"})
     */
    public function printAction(Request $request, ClientFactureAvoir $clientFactureAvoir)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $pdfInfo = $this->get('app.facture')->generate(
            $this->getUser(),
            $clientFactureAvoir,
            false,
            'FACTURE AVOIR',
            true,
            $this->getParameter('repertoire_upload')
        );

        $url = $request->getScheme() . '://' . $request->getHttpHost() .
            $request->getBasePath() . '/uploads/tmp/' . $pdfInfo->fileName;

        return new JsonResponse([
            'url' => $url,
            'filePath' => $pdfInfo->filePath
        ]);


        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientFactureAvoir);
        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientFactureAvoir);
        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientFactureAvoir);
        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientFactureAvoir);
        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientFactureAvoir);
        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFactureAvoir);
        $societe = $this->getUser()->getAgence()->getSociete();

        if(!is_null($societe->getLogo())){
            $urlLogo = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/uploads/societe/' . $societe->getLogo();
        }
        else{
            $urlLogo = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/frontend/img/icone_default_societe.jpg';
        }

        $html = $this->renderView('clientfacture/print.html.twig', [
            'clientFacture' => $clientFactureAvoir,
            'montantTotalHT' => $totalHT,
            'montantTotalTVA' => $totalTVA,
            'montantTotalAIB' => $totalAIB,
            'totalTaxeSpecifique' => $totalTaxeSpecifique,
            'montantTotalTTC' => $totalTTC,
            'montantTotalAPayer' => $totalAPayer,
            'societe' => $societe,
            'urlLogo' => $urlLogo,
        ]);

        $today = new \DateTime();
        $fileName = $clientFactureAvoir->getReference() . '_' . $today->format('d_m_Y_H_i_s') . '.pdf';
        $filesystem = new Filesystem();
        $target = $this->getParameter("repertoire_upload");
        $filePath = $target . "tmp/" . $fileName;

        try {
            $filesystem->mkdir('uploads/tmp/', 0700);

        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }

        $this->get('knp_snappy.pdf')->generateFromHtml($html, $filePath, [
            'margin-top' => 20,
            'margin-bottom' => 20,
        ]);
        $url = $request->getScheme() . '://' . $request->getHttpHost() .
            $request->getBasePath() . '/uploads/tmp/' . $fileName;

        $answer = [];
        $answer['url'] = $url;
        $answer['filePath'] = $filePath;
        return new JsonResponse($answer);
    }

    /**
     *
     * @Route("/{id}/print/definitive", options={"expose"=true},  name="clientfacturevente_print_definitive")
     * @Method({"GET", "POST"})
     */
    public function printDefinitiveAction(Request $request, ClientFactureAvoir $clientFactureAvoir)
    {
        $this->denyAccessUnlessGranted(['ROLE_USER', 'ROLE_ADMIN'], null,
            'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientFactureAvoir);
        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientFactureAvoir);
        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientFactureAvoir);
        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientFactureAvoir);
        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientFactureAvoir);
        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFactureAvoir);
        $societe = $this->getUser()->getAgence()->getSociete();
//        $societe = new ConfigSociete();
        if(!is_null($societe->getLogo())){
//            $logo = $societe->getLogo();
            $urlLogo = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/uploads/societe/' . $societe->getLogo();
        }
        else{
            $urlLogo = $request->getScheme() . '://' . $request->getHttpHost() .
                $request->getBasePath() . '/frontend/img/icone_default_societe.jpg';
        }
        $reponse = $clientFactureAvoir->getReponse();
        $dateHeureMCF = new \DateTime($reponse->getDateHeure());

        //Génération du code QR
        $qrCode = new QrCode('Life is too short to be generating QR codes');
//
//        header('Content-Type: '.$qrCode->getContentType());
        $qrCode->setSize(300);

// Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->set();
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->setLabel('Scan the code', 16, __DIR__.'/../assets/fonts/noto_sans.otf', LabelAlignment::CENTER());
        $qrCode->setLogoPath(__DIR__.'/../assets/images/symfony.png');
        $qrCode->setLogoSize(150, 200);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);
        dump($qrCode->getContentType());die();
//        dump(new \DateTime($reponse->getDateHeure()));die();
        $html = $this->renderView('clientfacture/print_definitive.html.twig', [
            'clientFacture' => $clientFactureVente,
            'montantTotalHT' => $totalHT,
            'montantTotalTVA' => $totalTVA,
            'montantTotalAIB' => $totalAIB,
            'totalTaxeSpecifique' => $totalTaxeSpecifique,
            'montantTotalTTC' => $totalTTC,
            'montantTotalAPayer' => $totalAPayer,
            'societe' => $societe,
            'urlLogo' => $urlLogo,
            'reponseDeclaration' => $reponse,
            'dateHeureMCF' => $dateHeureMCF,
        ]);

        $today = new \DateTime();
        $fileName = $clientFactureVente->getReference() . '_' . $today->format('d_m_Y_H_i_s') . '.pdf';
        $filesystem = new Filesystem();
        $target = $this->getParameter("repertoire_upload");
        $filePath = $target . "tmp/" . $fileName;
        try {
//            $filesystem->mkdir(sys_get_temp_dir().'/'.random_int(0, 1000));
//            $filesystem->remove($filePath);
            $filesystem->mkdir('uploads/tmp/', 0700);

        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }

//        $footer = $this->renderView('contratprecontratemploye/footer_precontrat.html.twig');
        $this->get('knp_snappy.pdf')->generateFromHtml($html, $filePath, [
            'margin-top' => 20,
            'margin-bottom' => 20,
//            'margin-right' => 30,
//            'margin-left' => 30,
//            'footer-left' => 'Imprimé le ' . $today->format('d/m/Y') . ' dans ' . $this->getParameter('app_code'),
//            'footer-html' => $footer
        ]);
        $url = $request->getScheme() . '://' . $request->getHttpHost() .
            $request->getBasePath() . '/uploads/tmp/' . $fileName;

        $answer = [];
        $answer['url'] = $url;
        $answer['filePath'] = $filePath;
//        dump($answer);die();
//        $this->get('generateur_mouchards')->genererUserMouchard(
//            $em->getRepository('ContratBundle:ContratPreContratEmploye')->getClassName(),
//            $this->getUser()->getuserPublicId(), 'téléchargement du précontrat généré', $request->getRequestUri(),
//            $this->getParameter('app_code'), $contratPreContratEmploye->getId());
        return new JsonResponse($answer);
    }

    /**
     * Creates a form to delete a clientFactureAvoir entity.
     *
     * @param ClientFactureAvoir $clientFactureAvoir The clientFactureAvoir entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ClientFactureAvoir $clientFactureAvoir)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientfactureavoir_delete', array('id' => $clientFactureAvoir->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Supprimer ClientFactureAvoir by setEstSupprimmer.
     *
     * @Route("/supprimmer/client/facture/avoir/{id}", name="supprimmer_client_facture_avoir")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ClientFactureAvoir $clientFactureAvoir, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $clientFactureAvoir->setEstSupprimer(true);

        $clientFactureAvoir->setUpdateBy($this->getUser()->getSlug());
        $clientFactureAvoir->setUpdatedAt(new \DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        return $this->redirectToRoute('clientfacture_index');

    }


}
