<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 02/10/2019
 * Time: 09:05
 */

namespace AppBundle\Twig;

use StockBundle\Entity\StockArticle;
use Doctrine\ORM\EntityManager;
use StockBundle\Entity\StockProduit;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use UserBundle\Entity\FosUser;

class AppExtension extends AbstractExtension
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('calculerPrixUnitaireTTC', [$this, 'calculerPrixUnitaireTTC']),
            new TwigFunction('typeOfProduit', [$this, 'getTypeOfProduit']),
        ];
    }

    public function getFilters() {
        return [
            new TwigFilter('getNumNotif', [$this, 'getNotification']),
        ];
    }

    public function getNotification(FosUser $user) {
        return $user->getId();
    }
//
    public function calculerPrixUnitaireTTC(StockProduit $stockProduit, $tauxTVA)
    {
        $prixUnitaireTTC = $stockProduit->getPrixUnitaireVente();

        if($stockProduit->getTaxable() == true){
//            $tauxTVA = $this->em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'tva']);
            $montantTVA = $stockProduit->getPrixUnitaireVente()* ($tauxTVA/100);
            $prixUnitaireTTC += $montantTVA;
        }
        if($stockProduit->getHasTaxeSpecifique() == true){
//            $taxeSpecifique = $this->em->getRepository('ConfigBundle:ConfigTaux')->findOneBy(['code' => 'tva']);
            $taxeSpecifique = $stockProduit->getPrixUnitaireVente()* ($stockProduit->getValeurTaxeSpecifique()/100);
            $prixUnitaireTTC += $taxeSpecifique;
        }
        return $prixUnitaireTTC;
    }

    public function getTypeOfProduit(StockProduit $produit)
    {
//        $type = 'produit';
        if ($produit instanceof StockArticle) {
            $type = 'article';
        } else {
            $type = 'service';
        }
        return $type;
    }
}