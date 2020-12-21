<?php

namespace OperationsClientBundle\Controller;

use ConfigBundle\Entity\ConfigTypeFacture;
use OperationsClientBundle\Entity\ClientDevis;
use OperationsClientBundle\Entity\ClientFacture;
use StockBundle\Entity\StockProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TiersBundle\Entity\TiersClient;

class DefaultController extends Controller
{

    protected function getData(Request $request, ClientFacture $clientFacture, $edit = false, $facture = false) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $agence = $user->getAgence();
        $societe = $agence->getSociete();

        $configTypeFacture = !$facture ?
            $em->getRepository(ConfigTypeFacture::class)->findOneBy(['code' => 'DV']) :
            $em->getRepository('ConfigBundle:ConfigTypeFacture')->findOneBy(['code' => 'FV','estSupprimer'=>0])
        ;

        $clientFacture->setTypeFacture($configTypeFacture);

        //Création de la référence
        //On vérifie dans les paramètres de génération si la référence du service est à générer automatiquement ou pas.
        $estGenere = $em->getRepository('ConfigBundle:ConfigTypeGenerationSociete')->findBy(['societe' => $societe,'estSupprimer'=>0,'estGenere'=>1]);

        if ($estGenere != null && $estGenere != '' && $estGenere != [] && count($estGenere) > 0) {
            if (!$clientFacture->getReference()) {
                $reference = $this->get('code_generate')->genererReferenceFacture($clientFacture->getTypeFacture(),$societe->getId());
                $clientFacture->setReference($reference);
            }
        } else{
            $request->getSession()->getFlashBag()->add('success', 'Veuillez activer une Génération de code.');
            return $this->redirectToRoute('configtypegeneration_index');
        }

        $clientFacture->setAgence($agence);
        $clientFacture->setUser($user);
        $clientFacture->setEstSupprimer(0);

        if ($societe->getAssujetiTva() == true) {
            $tauxTVA = $societe->getPays()->getTauxTva();
            $clientFacture->setTauxTVA($tauxTVA);
        }

        if ($facture) {
            $form = $this->createForm('OperationsClientBundle\Form\ClientFactureVenteType', $clientFacture, [
                'entity_manager' => $em, 'type_activite' => $societe->getTypeActivite()->getCode()
            ]);
        } else {
            $form = $this->createForm('OperationsClientBundle\Form\ClientDevisType', $clientFacture, [
                    'entity_manager' => $em, 'type_activite' => $societe->getTypeActivite()->getCode()
                ]
            );
        }

        $json = [
            'stock' => $em->getRepository(StockProduit::class)->listProduit($societe),
            'clients' => $em->getRepository(TiersClient::class)->listClient($societe),
            'assujetiTva' => $societe->getAssujetiTva(),
            'liberal' => $societe->getEstProfessionLiberale(),
            'devise' => $societe->getDevise()->getId(),
            'roundPrice' => $this->getParameter('arrondir_au_franc')
        ];

        if ($edit) {
            $json['edit'] = $em->getRepository(ClientFacture::class)->getEditInfo($clientFacture);
        }
        $client = $clientFacture->getClient();

        $key = 'clientDevis';
        if ($facture) {
            $key = 'clientFacture';
        }
        $data = [
            $key => $clientFacture,
            'form' => $form->createView(),
            'json' => json_encode($json)
        ];

        return compact('data', 'form', 'user', 'agence', 'societe', 'em', 'client');
    }

}
