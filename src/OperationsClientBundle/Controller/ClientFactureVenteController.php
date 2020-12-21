<?php

namespace OperationsClientBundle\Controller;

use AppBundle\Service\Fpdf;
use AppBundle\Service\Pdf;
use ConfigBundle\Entity\ConfigSociete;
use ConfigBundle\Entity\ConfigTypeFacture;
use DateTime;
use OperationsClientBundle\Entity\ClientDevis;
use OperationsClientBundle\Entity\ClientFactureDetail;
use OperationsClientBundle\Repository\ClientDevisRepository;
use StockBundle\Entity\StockProduit;
use Symfony\Component\Filesystem\Filesystem;
use OperationsClientBundle\Entity\ClientFactureVente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Client;
use TiersBundle\Entity\TiersClient;
use UserBundle\Entity\FosUser;
use Endroid\QrCode\QrCode;

/**
 * Clientfacturevente controller.
 *
 * @Route("clientfacturevente")
 */
class ClientFactureVenteController extends DefaultController
{
    /**
     * Creates a new clientFactureVente entity.
     *
     * @Route("/new", name="clientfacturevente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $clientFacture = new ClientFactureVente();
        $devis = false;
        if ($request->get('devis')) {
            $devis = true;
            $id = (int)$request->get('devis');
//            dump($id); die();
            $clientDevis = $this->getDoctrine()->getRepository(ClientDevis::class)->find($id);
            $clientFacture = $this->getDoctrine()->getRepository(ClientDevis::class)->buildeFactureVente(
                $clientDevis,
                $this->getUser(),
                $this->get('code_generate')
            );
        }

        extract($this->getData($request, $clientFacture, $devis, true), EXTR_OVERWRITE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($clientFacture->getDetails() as &$detail) {
                $detail->setTauxAIB($detail->getTauxAIB()/$detail->getPrixVenteUnitaire());
            }
            unset($detail);
            $em = $this->getDoctrine()->getManager();

            $clientFacture->setAgence($agence);
            $clientFacture->setSociete($agence->getSociete());
            $clientFacture->setUser($user);

            $clientFacture->setCreated(new DateTime());
            $clientFacture->setCreatedBy($this->getUser()->getSlug());
            $clientFacture->setEstSupprimer(0);

            $em->persist($clientFacture);
            $details = $clientFacture->getDetails();
            foreach ($details as $detail) {
                $detail->setFacture($clientFacture);

                if (!$detail->getAibDeductible()) {
                    $detail->setAibDeductible(0)->setTauxAIB(0);
                }


                $detail->setCreated(new DateTime());
                $detail->setCreatedBy($this->getUser()->getSlug());
                $detail->setEstSupprimer(0);

            }
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Création effectuée avec succès');
            return $this->redirectToRoute('clientfacturevente_show', array('id' => $clientFacture->getId()));
        }

//        dump(json_decode($data['json']), $data); die();
        return $this->render('clientfacturevente/new.html.twig', $data);
    }

    /**
     * Finds and displays a clientFactureVente entity.
     *
     * @Route("/{id}", name="clientfacturevente_show")
     * @Method("GET")
     * @param Request            $request
     * @param ClientFactureVente $clientFactureVente
     *
     * @return RedirectResponse|Response
     */
    public function showAction(Request $request, ClientFactureVente $clientFactureVente)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($clientFactureVente);
        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientFactureVente);
        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientFactureVente);
        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientFactureVente);
        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientFactureVente);
        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientFactureVente, $totalHT, $totalTVA, $totalAIB, $totalTaxeSpecifique);
        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFactureVente, $totalTTC, $totalAIB);

        return $this->render('clientfacturevente/show.html.twig', array(
            'clientFacture' => $clientFactureVente,
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
     * Displays a form to edit an existing clientFactureVente entity.
     *
     * @Route("/{id}/edit", name="clientfacturevente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ClientFactureVente $clientFactureVente)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        extract($this->getData($request, $clientFactureVente, true, true), EXTR_OVERWRITE);
        $deleteForm = $this->createDeleteForm($clientFactureVente);

        $donnees = $request->request->get('operationsclientbundle_clientfacturevente');
        $donnees['client'] = $client->getId();
        $request->request->set('operationsclientbundle_clientfacturevente', $donnees);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $details = $clientFactureVente->getDetails();
            /** @var ClientFactureDetail $detail */
            foreach ($details as $detail) {
                $detail->setFacture($clientFactureVente);

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
            return $this->redirectToRoute('clientfacturevente_show', array('id' => $clientFactureVente->getId()));
        }

        $donnees['delete_form'] = $deleteForm->createView();

        return $this->render('clientfacturevente/new.html.twig', $data);
    }


    /*public function editerAction(Request $request, ClientFactureVente $clientFactureVente)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $deleteForm = $this->createDeleteForm($clientFactureVente);
        $em = $this->getDoctrine()->getManager();
        $societe = $this->getUser()->getAgence()->getSociete();
        $editForm = $this->createForm('OperationsClientBundle\Form\ClientFactureVenteType', $clientFactureVente, [
            'entity_manager' => $em, 'type_activite' => $societe->getTypeActivite()->getCode()
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $details = $clientFactureVente->getDetails();
            foreach ($details as $detail) {
                $detail->setFacture($clientFactureVente);

                if (!$detail->getAibDeductible()) {
                    $detail->setAibDeductible(0)->setTauxAIB(0);
                }

                $detail->setUpdateBy($this->getUser()->getSlug());
                $detail->setUpdateAt(new DateTime());
            }
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'Modification effectuée avec succès');
            return $this->redirectToRoute('clientfacturevente_show', array('id' => $clientFactureVente->getId()));
        }


        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientFactureVente);
        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientFactureVente);
        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientFactureVente);
        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientFactureVente);
        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientFactureVente);
        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFactureVente);


        return $this->render('clientfacturevente/edit.html.twig', array(
            'clientFacture' => $clientFactureVente,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

            'montantTotalHT' => $totalHT,
            'montantTotalTVA' => $totalTVA,
            'montantTotalAIB' => $totalAIB,
            'totalTaxeSpecifique' => $totalTaxeSpecifique,
            'montantTotalTTC' => $totalTTC,
            'montantTotalAPayer' => $totalAPayer,
        ));
    }*/





    /**
     * Creates a new clientFacture avoir entity.
     *
     * @Route("/choisir/avoir", name="clientfacture_choisir_avoir")
     * @Method({"GET", "POST"})
     */

    public function choisirFacturePourAvoirAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        if ($request->isMethod('POST')) {
            $idFactureOrigine = $request->get('facture_origine');
            return $this->redirectToRoute('clientfactureavoir_new', [
                'idFactureOrigine' => $idFactureOrigine]);
        }
        return $this->redirectToRoute('clientfacture_index');
    }

    /**
     *
     * @Route("/{id}/print", options={"expose"=true},  name="clientfacturevente_print")
     * @Method({"GET", "POST"})
     * @param Request            $request
     * @param ClientFactureVente $clientFactureVente
     *
     * @return JsonResponse|RedirectResponse
     */
    public function printAction(Request $request, ClientFactureVente $clientFactureVente)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        
        $this->denyAccessUnlessGranted(['ROLE_USER', 'ROLE_ADMIN'], null, 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
//        $totalHT = $this->get('client_operations')->calculerMontantFactureHT($clientFactureVente);
//        $totalTVA = $this->get('client_operations')->calculerMontantTVAFacture($clientFactureVente);
//        $totalAIB = $this->get('client_operations')->calculerMontantAIBFacture($clientFactureVente);
//        $totalTaxeSpecifique = $this->get('client_operations')->calculerTotalTaxeSpecifiqueFacture($clientFactureVente);

//        $totalTTC = $this->get('client_operations')->calculerMontantFactureTTC($clientFactureVente, $totalHT, $totalTVA, $totalAIB, $totalTaxeSpecifique);
//        $totalAPayer = $this->get('client_operations')->calculerMontantNetAPayer($clientFactureVente, $totalTTC, $totalAIB);

//        $societe = $this->getUser()->getAgence()->getSociete();

//        if(!is_null($societe->getLogo())){
//            $logo = $societe->getLogo();
//            $urlLogo = $request->getScheme() . '://' . $request->getHttpHost() .
//                $request->getBasePath() . '/uploads/societe/' . $societe->getLogo();
//        }

        $pdfInfo = $this->get('app.facture')->generate(
            $this->getUser(),
            $clientFactureVente,
            false,
            'FACTURE PROVISOIRE',
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
     *
     * @Route("/{id}/print/definitive", options={"expose"=true},  name="clientfacturevente_print_definitive")
     * @Method({"GET", "POST"})
     * @param Request            $request
     * @param ClientFactureVente $clientFactureVente
     *
     * @return Response
     */
    public function printDefinitiveActionFPDF(Request $request, ClientFactureVente $clientFactureVente)
    {

        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $this->denyAccessUnlessGranted(['ROLE_USER', 'ROLE_ADMIN'], null, 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $pdf = $this->get('app.facture')->generate(
            $this->getUser(),
            $clientFactureVente,
            true
        );

        return new Response(
            $pdf->Output(),
            Response::HTTP_OK,
            ['content-type' => 'application/pdf']
        );
    }

    /**
     * Deletes a clientFactureVente entity.
     *
     * @Route("/{id}", name="clientfacturevente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ClientFactureVente $clientFactureVente)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['ROLE_CLT_ADMIN','ROLE_ADMIN']);
        if (!$auth) {
            $request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $form = $this->createDeleteForm($clientFactureVente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clientFactureVente);
            $em->flush();
        }

        return $this->redirectToRoute('clientfacturevente_index');
    }

    /**
     * Creates a form to delete a clientFactureVente entity.
     *
     * @param ClientFactureVente $clientFactureVente The clientFactureVente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ClientFactureVente $clientFactureVente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientfacturevente_delete', array('id' => $clientFactureVente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Supprimer ClientFactureVente by setEstSupprimmer.
     *
     * @Route("/supprimmer/client/facture/vente/{id}", name="supprimmer_client_facture_vente")
     * @Method({"GET", "POST"})
     */
    public function supprimmer(ClientFactureVente $clientFactureVente, Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $clientFactureVente->setEstSupprimer(true);

        $clientFactureVente->setUpdateBy($this->getUser()->getSlug());
        $clientFactureVente->setUpdatedAt(new DateTime());
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Suppression réussie.');
        return $this->redirectToRoute('clientfacture_index');
    }


}
