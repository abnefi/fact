<?php


namespace AppBundle\Service;

use OperationsClientBundle\Entity\ClientFacture;
use OperationsClientBundle\Entity\ClientFactureDetail;
use StockBundle\Entity\StockApprovisionnement;
use StockBundle\Entity\StockApprovisionnementDetail;
use StockBundle\Entity\StockProduit;
use Symfony\Component\DependencyInjection\Container as Container;

class StockOperations
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;

    public function __construct(\Doctrine\ORM\EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function calculerMontantApprovisionnement(StockApprovisionnement $stockApprovisionnement)
    {
        $details = $stockApprovisionnement->getDetails();
        $montantTotal = 0;
        foreach ($details as $detail) {
            $montant = $detail->getQuantite() * $detail->getCoutAchatUnitaire();
            $montantTotal += $montant;
        }
        return $montantTotal;
    }

    public function calculerPrixUnitaireTTC(StockProduit $stockProduit)
    {
        $prixUnitaireTTC = $stockProduit->getPrixUnitaireVente();
        /*
        if($stockProduit->getTaxable() == true){
            $tauxTVA = $this->em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'tva']);
            $montantTVA = $stockProduit->getPrixUnitaireVente()* ($tauxTVA->getValeurTaux()/100);
            $prixUnitaireTTC += $montantTVA;
        }
        if($stockProduit->getHasTaxeSpecifique() == true){
//            $taxeSpecifique = $this->em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'tva']);
            $taxeSpecifique = $stockProduit->getPrixUnitaireVente()* ($stockProduit->getValeurTaxeSpecifique()/100);
            $prixUnitaireTTC += $taxeSpecifique;
        }
        */


        return $prixUnitaireTTC;
    }

    public function updateStockDisponibleArticle(StockApprovisionnementDetail $detail)
    {
        $article = $detail->getArticle();
        $newStockDispo = $article->getStockDisponible() - $detail->getQuantite();
//        return $montantTotal;
    }
}