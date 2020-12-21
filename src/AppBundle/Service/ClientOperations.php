<?php
/**
 * Created by PhpStorm.
 * User: daouda
 * Date: 18/02/2020
 * Time: 12:52
 */

namespace AppBundle\Service;

use ConfigBundle\Entity\ConfigSociete;
use OperationsClientBundle\Entity\ClientFacture;
use OperationsClientBundle\Entity\ClientFactureDetail;
use Symfony\Component\DependencyInjection\Container as Container;

class ClientOperations
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

    public function calculerMontantFactureHT(ClientFacture $facture)
    {
        $details = $facture->getDetails();
        $montantTotal = 0;
        foreach ($details as $detail) {
//            $detail = new ClientFactureDetail();
            $montant = $detail->getQuantite() * $detail->getPrixVenteUnitaire();
            $montantTotal += $montant;
        }
        return $montantTotal;
    }

    public function calculerTaxeSejour(ClientFacture $facture) {
        $taxe = 0;
        foreach ($facture->getDetails() as $detail) {
//            $detail = new ClientFactureDetail();
            $taxe += $detail->getTaxeDeSejour();
        }
        return $taxe;
    }

    public function calculerProduitTTC(ClientFactureDetail $detail) {
        $facture    = $detail->getFacture();
        $configTaxeGroupe = $detail->getProduit()->getTaxeGroupe();
        $montant    = $detail->getQuantite() * $detail->getPrixVenteUnitaire();
        $tva = 0;
        if ($configTaxeGroupe) {
            $code       = $configTaxeGroupe->getCode();
            $tva        = ($facture->getSociete()->getAssujetiTva() && $code !== 'A' && $code !== 'E') ? $montant * ($facture->getTauxTVA() / 100) : 0;
        }
        $aib        = $detail->getAibDeductible() ? $detail->getQuantite() * $detail->getPrixVenteUnitaire() * $detail->getTauxAIB() : 0;

        return      $montant + $tva + $aib + $detail->getTaxeDeSejour() + $detail->getTaxeSpecifique();
    }

    public function calculerMontantFactureTTC(ClientFacture $facture, $ht = null, $tva = null, $aib = null, $taxeSpecifique = null)
    {
        if ($ht === null) {
            $ht = $this->calculerMontantFactureHT($facture);
        }
        if ($tva === null) {
            $tva = $this->calculerMontantTVAFacture($facture);
        }
        if ($aib === null) {
            $aib = $this->calculerMontantAIBFacture($facture);
        }
        if ($taxeSpecifique === null) {
            $taxeSpecifique = $this->calculerTotalTaxeSpecifiqueFacture($facture);
        }
        return $ht + $tva + $aib + $taxeSpecifique + $this->calculerTaxeSejour($facture);
    }

    public function calculerMontantNetAPayer(ClientFacture $facture, $ttc = null, $aib = null)
    {
        if ($ttc === null) {
            $ttc = $this->calculerMontantFactureTTC($facture);
        }
        if ($aib === null) {
            $aib = $this->calculerMontantAIBFacture($facture);
        }
        if (
            $facture->getClient()->getEstPersonneMoral() &&
            $this->getUser()->getAgence()->getSociete()->getEstProfessionLiberale()
        ) {
            $ttc -= $aib;
        }
        return $ttc;
    }

    public function calculerMontantTVAFacture(ClientFacture $facture)
    {
        $details = $facture->getDetails();
        $montantTva = 0;
        foreach ($details as $detail) {
//            $detail = new ClientFactureDetail();
            $configTaxeGroupe = $detail->getProduit()->getTaxeGroupe();
            $montant = $detail->getQuantite() * $detail->getPrixVenteUnitaire();

            if ($configTaxeGroupe) {
                // La TVA s'applique uniquement sur les articles taxables des entreprises assujetti à la tva
                $code = $configTaxeGroupe->getCode();
                if ($facture->getSociete()->getAssujetiTva() && $code !== 'A' && $code !== 'E') {
                    $tva = $montant * ($facture->getTauxTVA() / 100);
                    $montantTva += $tva;
                }
            }
        }
        return $montantTva;
    }

    public function calculerTotalTaxeSpecifiqueFacture(ClientFacture $facture)
    {
        $details = $facture->getDetails();
        $montantTaxeSpecifique = 0;
        foreach ($details as $detail) {
//            $detail = new ClientFactureDetail();
            // La TVA s'applique uniquement sur les articles taxables
            if ($detail->getHasTaxeSpecifique()) {
                $montantTaxeSpecifique += $detail->getTaxeSpecifique();
            }
        }
        return $montantTaxeSpecifique;
    }

    public function calculerMontantAIBFacture(ClientFacture $facture)
    {
        $details = $facture->getDetails();
        $montantAIB = 0;
        foreach ($details as $detail) {
//            $detail = new ClientFactureDetail();
            if ($detail->getAibDeductible()) {
                $montantAIB += $detail->getQuantite() * $detail->getPrixVenteUnitaire() * $detail->getTauxAIB();
            }
        }
        return $montantAIB;
    }

    public function calculerMontantDejaPaye(ClientFacture $facture)
    {
        $paiements = $this->em->getRepository('OperationsClientBundle:ClientPaiement')
            ->findBy(['facture' => $facture,'supprimer'=>0]);
        $montantTotal = 0;
        foreach ($paiements as $paiement) {
            $montantTotal += $paiement->getMontant();
        }
        return $montantTotal;
    }
}