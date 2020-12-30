<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 13/02/2020
 * Time: 17:56
 */

namespace OperationsClientBundle\Controller;

use ConfigBundle\Entity\ConfigSociete;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use StockBundle\Entity\StockArticle;
use StockBundle\Entity\StockProduit;
use StockBundle\Entity\StockService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TiersBundle\Entity\TiersClient;
use UserBundle\Entity\MouchardFichier;
use Symfony\Component\HttpFoundation\Session\Session;

class OperationsClientAjaxController extends Controller
{

    /**
     *
     * @Route("/{id}/facture/get/infos/produit", options={"expose"=true}, name="get_infos_produit")
     * @Method({"GET", "POST"})
     */
    public function getInfosProduitAction(Request $request, StockProduit $produit)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $responseArray = [];
        $type = 'produit';
        if ($produit instanceof StockArticle) {
            $type = 'article';
            $responseArray['qteDispo'] = $produit->getStockDisponible();
            $uniteMesure = $em->getRepository('ConfigBundle:ConfigUniteMesure')->findOneBy(['code' => 'item','estSupprimer'=>0]);
            $responseArray['uniteMesure'] = $uniteMesure->getId();
        } else {
            $type = 'service';
            $responseArray['uniteMesure'] = $produit->getUniteMesure()->getId();
        }
        $hasTaxeSpecifique = $produit->getHasTaxeSpecifique();
        if ($hasTaxeSpecifique == true) {
            $valeurTaxeSpecifique = $produit->getValeurTaxeSpecifique();
            $responseArray['valeurTaxeSpecifique'] = $valeurTaxeSpecifique;
        } else {
            $responseArray['valeurTaxeSpecifique'] = 0;
        }
        $responseArray['hasTaxeSpecifique'] = $hasTaxeSpecifique;
        $responseArray['type'] = $type;
        $responseArray['prixUnitaire'] = $produit->getPrixUnitaireVente();
        $responseArray['prixUnitaireTTC'] = $this->get('stock_operations')->calculerPrixUnitaireTTC($produit);
        $responseArray['taxable'] = $produit->getTaxable();
        return new JsonResponse($responseArray);
    }

    /**
     *
     * @Route("/facture/get/infos/societe", options={"expose"=true}, name="get_infos_societe")
     * @Method({"GET", "POST"})
     */
    public function getInfosSocieteAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        $configSociete = $this->getUser()->getAgence()->getSociete();
        $responseArray = [];
        $responseArray['idDevise'] = $configSociete->getDevise()->getId();
        $responseArray['codeDevise'] = $configSociete->getDevise()->getCode();
        $responseArray['libelleDevise'] = $configSociete->getDevise()->getLibelle();
        $responseArray['symboleDevise'] = $configSociete->getDevise()->getSymbole();
//      dump($responseArray);die();
        return new JsonResponse($responseArray);
    }

    /**
     *
     * @Route("/{id}/facture/get/aib/client", options={"expose"=true}, name="get_aib_by_client")
     * @Method({"GET", "POST"})
     */
    public function getTauxAibByClientAction(Request $request, TiersClient $client)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $ifu = $client->getIfu();

        if (strlen($ifu) >= 13) { //si le client a un numéro IFU
            $tauxAIB = $em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'aib_avec_ifu','estSupprimer'=>0]);
        } else {
            $tauxAIB = $em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'aib_sans_ifu','estSupprimer'=>0]);

        }
        $societe = $this->getUser()->getAgence()->getSociete();
        $codePaysSociete = $societe->getPays()->getCodePays();

        $client = $em->getRepository('TiersBundle:TiersClient')->findOneBy(['id' => $client->getId(),'estSupprimer'=>0,'societe'=>$societe]);
        $codePaysClient = $client->getPays()->getCodePays();

        if ($codePaysSociete === $codePaysClient)
            $tauxTVA = $societe->getPays()->getTauxTva();
        else
            $tauxTVA = 0;

        $responseArray = [];
        $responseArray['tauxAib'] = $tauxAIB->getValeurTaux();
        $responseArray['tauxTVA'] = $tauxTVA;

        return new JsonResponse($responseArray);
    }

    /**
     *
     * @Route("/get/produits/by/type", options={"expose"=true}, name="get_produits_by_type")
     * @Method({"GET", "POST"})
     */

    public function getProduitsByTypeAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $typeProduit = $request->get('type_produit');
        $societe = $this->getUser()->getAgence()->getSociete();


        if ($typeProduit == 'article')
        {
            $produits = $em->getRepository('StockBundle:StockArticle')->findBy(['estSupprimer'=>0,'societe'=>$societe]);
        } else {
            $produits = $em->getRepository('StockBundle:StockService')->findBy(['estSupprimer'=>0,'societe'=>$societe]);
        }

        $arrayProduits = [];
        foreach ($produits as $produit) {
            $ligneProduit = [];
            $ligneProduit['id'] = $produit->getId();
            $ligneProduit['designation'] = $produit->getDesignation();
            $arrayProduits[] = $ligneProduit;
        }

        return new JsonResponse($arrayProduits);
    }

    /**
     * @Route("/filtrer/factures", options={"expose"=true}, name="filtrer_factures")
     * @Method({"Post"})
     */
    public function filtrerFacturesAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $selectedTypesFacture = $request->get('selectTypesFacture');
            $tempsFactureActif = $request->get('tempsFactureActif');
            $tempsFacture = $request->get('tempsFacture');
            $selectedClients = $request->get('selectClients');
            $etatDeclarationId = $request->get('selectEtatDeclaration');

            $configSociete = $this->getUser()->getAgence()->getSociete();

            $factures = $em->getRepository("OperationsClientBundle:ClientFacture")->getByFiltres($tempsFactureActif,
                $tempsFacture, $selectedTypesFacture, $selectedClients, $etatDeclarationId, $configSociete);

            if ($factures == null) {
                return new Response('<html><body><div class="alert alert-info alert-danger" role="alert">
                <b>Aucune facture n\'a été retrouvée !</b></div></body></html>');
            }
            return $this->render('clientfacture/ajax/tableauFiltrage.html.twig', array(
                'clientFactures' => $factures,
            ));
        }
    }

    /**
     * @Route("/get/facture/by/client", options={"expose"=true}, name="facture_by_client")
     * @Method({"Post"})
     */
    public function getfactureByClientAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $clientId = $request->get('client');
            $societe = $this->getUser()->getAgence()->getSociete();
            $factures_client = $em->getRepository("OperationsClientBundle:ClientFactureVente")->findBy(array('client' => $clientId,'estSupprimer'=>0,'societe'=>$societe), array('id' => 'DESC'), 5);


            return $this->render('clientfacture/ajax/selectFacture.html.twig', array(
                'facturesVente_SansAvoirs' => $factures_client,
            ));
        }
    }


    /**
     * @Route("/get/facture/by/client/all", options={"expose"=true}, name="facture_by_client_all")
     * @Method({"Post"})
     */
    public function getfactureByClientAllAction(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $clientId = $request->get('client');
            $societe = $this->getUser()->getAgence()->getSociete();

            $factures_client = $em->getRepository("OperationsClientBundle:ClientFactureVente")->findBy(array('client' => $clientId,'estSupprimer'=>0,'societe'=>$societe), array('id' => 'DESC'));


            return $this->render('clientfacture/ajax/selectFacture.html.twig', array(
                'facturesVente_SansAvoirs' => $factures_client,
            ));
        }
    }

    /**
     * Search for sponsor info
     * @Route("/get/compte/client/by/name", name="get_compte_client_by_name", options= {"expose" = true})
     * @Method({"POST"})
     */
    public function getClientByName(Request $request)
    {
        $auth = $this->get('security.authorization_checker')->isGranted(['IS_AUTHENTICATED_FULLY']);

        if (!$auth || $this->get('security.authorization_checker')->isGranted(['ROLE_VISITEUR','ROLE_FNS_ADMIN','ROLE_CLT_ADMIN'])) {$request->getSession()->getFlashBag()->add('echec', 'Désolé, vous n\'avez pas le droit d\'accès à cette page.');
            return $this->redirectToRoute('fos_user_security_login');
        }
        if ($request->isXmlHttpRequest()) {
            $keyword = $request->get('keyword');
            $typeRequete = $request->get('typeRequete');
            $data = [
                'keyword' => $keyword,
//                'page' => $page,
                'typeRequete' => $typeRequete,
//                'nbreParpage' => $nbreParpage,
            ];


            $em = $this->getDoctrine()->getManager();


            $search_client_name = $em->getRepository("TiersBundle:TiersClient")->searchClientName($keyword);

            $result = array();
            $result['items'] = $search_client_name;


            return new JsonResponse($result);


        }
    }
}